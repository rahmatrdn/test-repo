<?php

namespace App\Usecase\superAdmin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SchoolUsecase extends Usecase
{
    public function __construct()
    {
    }

    public function getAll(array $filterData = []): array
    {
        try {
            $data = DB::table(DatabaseConst::SCHOOL)
                ->when($filterData['status'] ?? 'all', function ($query, $status) {
                    if ($status === 'active') {
                        return $query->whereNull('deleted_at');
                    } elseif ($status === 'inactive') {
                        return $query->whereNotNull('deleted_at');
                    }

                    return $query;
                })
                ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                    return $query->where(function ($q) use ($keywords) {
                        $q->where('school_name', 'like', '%' . $keywords . '%')
                            ->orWhere('address', 'like', '%' . $keywords . '%')
                            ->orWhere('no_tlp', 'like', '%' . $keywords . '%');
                    });
                })
                ->orderBy('created_at', 'asc')
                ->paginate(20);

            if (!empty($filterData)) {
                $data->appends($filterData);
            }

            return Response::buildSuccess(
                [
                    'list' => $data,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getByID(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::SCHOOL)
                ->where('id', $id)
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data sekolah tidak ditemukan');
            }

            return Response::buildSuccess(
                data: collect($data)->toArray()
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'school_name' => 'required|string|max:255',
            'mou_date' => 'nullable|date',
            'address' => 'nullable|string',
            'no_tlp' => 'nullable|string',
        ]);

        $validator->validate();

        DB::beginTransaction();

        try {
            $payload = $data->only(['school_name', 'mou_date', 'address', 'no_tlp']);
            $payload['updated_by'] = Auth::user()?->id;
            $payload['updated_at'] = now();

            DB::table(DatabaseConst::SCHOOL)
                ->where('id', $id)
                ->update($payload);

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();

        try {
            $delete = DB::table(DatabaseConst::SCHOOL)
                ->where('id', $id)
                ->update([
                    'deleted_by' => Auth::user()?->id,
                    'deleted_at' => now(),
                ]);

            if (!$delete) {
                DB::rollback();
                throw new Exception('FAILED DELETE DATA');
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function restore(int $id): array
    {
        DB::beginTransaction();

        try {
            $restore = DB::table(DatabaseConst::SCHOOL)
                ->where('id', $id)
                ->update([
                    'deleted_by' => null,
                    'deleted_at' => null,
                ]);

            if (!$restore) {
                DB::rollback();
                throw new Exception('FAILED RESTORE DATA');
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_RESTORED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }
}

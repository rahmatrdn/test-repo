<?php

namespace App\Usecase\Admin;

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
                ->whereNull('deleted_at')
                ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                    return $query->where(function ($q) use ($keywords) {
                        $q->where('name', 'like', '%' . $keywords . '%')
                            ->orWhere('email', 'like', '%' . $keywords . '%');
                    });
                })
                ->when($filterData['access_type'] ?? false, function ($query, $accessType) {
                    if ($accessType !== 'all') {
                        return $query->where('access_type', $accessType);
                    }
                })
                ->orderBy('created_at', 'desc')
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

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'school_name' => 'required|string|max:255',
            'grade' => 'required|integer',
            'address' => 'nullable|string',
            'no_tlp' => 'nullable|string|max:20',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userID = Auth::user()?->id;

            if (!$userID) {
                throw new Exception('User not authenticated');
            }

            $user = DB::table(DatabaseConst::USER)
                ->where('id', $userID)
                ->whereNull('deleted_at')
                ->first(['school_id']);

            if ($user && $user->school_id) {
                throw new Exception('User sudah terdaftar di sekolah');
            }

            $payload = $data->only([
                'school_name',
                'grade',
                'address',
                'no_tlp',
            ]);
            $payload['mou_date'] = now();
            $payload['created_by'] = $userID;
            $payload['created_at'] = now();
            $payload['updated_at'] = now();

            $schoolID = DB::table(DatabaseConst::SCHOOL)->insertGetId($payload);

            DB::table(DatabaseConst::USER)->where('id', $userID)->update([
                'school_id' => $schoolID,
                'updated_by' => $userID,
                'updated_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccessCreated();
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

    public function getByID(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::SCHOOL)
                ->whereNull('deleted_at')
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
            'grade' => 'required|integer',
            'mou_date' => 'nullable|date',
            'address' => 'nullable|string',
            'no_tlp' => 'nullable|string|max:20',
        ]);

        $validator->validate();

        DB::beginTransaction();

        try {
            $payload = $data->only(['school_name', 'grade', 'mou_date', 'address', 'no_tlp']);
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
        } catch (\Exception $e) {
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

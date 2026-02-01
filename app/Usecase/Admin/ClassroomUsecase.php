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

class ClassroomUsecase extends Usecase
{
   public function getAll(array $filterData = []): array
{
    try {
        $userSchoolId = Auth::user()?->school_id;

        $query = DB::table(DatabaseConst::CLASSROOM)
            ->whereNull('deleted_at')
            ->where('school_id', $userSchoolId)
            ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                return $query->where('class_name', 'like', '%' . $keywords . '%');
            })
            ->orderBy('created_at', 'desc');

        if (! empty($filterData['no_pagination'])) {
            $data = $query->get();
        } else {
            $data = $query->paginate(20);

            if (! empty($filterData)) {
                $data->appends($filterData);
            }
        }

        if (method_exists($data, 'getCollection')) {
            $data->getCollection()->transform(function ($item) {
                $currentYear = now()->year;
                $entryYear = (int) $item->entry_year;

                $grade = ($currentYear - $entryYear) + 10;
                $item->display_name = $grade . ' ' . $item->class_name;

                return $item;
            });
        } else {
            $data->transform(function ($item) {
                $currentYear = now()->year;
                $entryYear = (int) $item->entry_year;

                $grade = ($currentYear - $entryYear) + 10;
                $item->display_name = $grade . ' ' . $item->class_name;

                return $item;
            });
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
            context: ['method' => __METHOD__]
        );

        return Response::buildErrorService($e->getMessage());
    }
}


    public function getByID(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::CLASSROOM)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (! $data) {
                return Response::buildErrorService(ResponseConst::ERROR_MESSAGE_NOT_FOUND);
            }

            $currentYear = now()->year;
            $entryYear = (int) $data->entry_year;
            $grade = ($currentYear - $entryYear) + 10;

            $data->display_name = $grade . ' ' . $data->class_name;

            return Response::buildSuccess(
                data: collect($data)->toArray()
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'entry_year' => 'required|date_format:Y',
            'class_name' => 'required|string|max:255',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $payload = $data->only([
                'entry_year',
                'class_name',
            ]);

            $payload['school_id'] = Auth::user()?->school_id;
            $payload['created_by'] = Auth::user()?->id;
            $payload['created_at'] = now();
            $payload['updated_at'] = now();

            DB::table(DatabaseConst::CLASSROOM)->insert($payload);

            DB::commit();

            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'entry_year' => 'required|date_format:Y',
            'class_name' => 'required|string|max:255',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $payload = $data->only([
                'entry_year',
                'class_name',
            ]);

            $payload['updated_by'] = Auth::user()?->id;
            $payload['updated_at'] = now();

            DB::table(DatabaseConst::CLASSROOM)
                ->where('id', $id)
                ->where('school_id', Auth::user()?->school_id)
                ->update($payload);

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            $delete = DB::table(DatabaseConst::CLASSROOM)
                ->where('id', $id)
                ->update([
                    'deleted_by' => Auth::user()?->id,
                    'deleted_at' => now(),
                ]);

            if (! $delete) {
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
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }
}

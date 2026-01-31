<?php

namespace App\Usecase\Teacher;

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

class AiMateriAjarUsecase extends Usecase
{

    public function getAll(array $filterData = []): array
    {
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $query = DB::table(DatabaseConst::TEXT_GENERATION_HISTORY . ' as tgh')
                ->where('tgh.created_by', $userId)
                ->whereNull('tgh.deleted_at')
                ->select(
                    'tgh.id',
                    'tgh.user_input',
                    'tgh.output_text',
                    'tgh.output_file_path',
                    'tgh.type',
                    'tgh.created_at',
                )
                ->orderBy('tgh.created_at', 'desc');

            if (!empty($filterData['keywords'])) {
                $query->where('tgh.user_input', 'like', '%' . $filterData['keywords'] . '%')->orWhere('tgh.output_text', 'like', '%' . $filterData['keywords'] . '%');
            }
            if(request()->has('type') && request()->get('type') != 'all') {
                $query->where('tgh.type', $filterData['type']);
            }

            $data = $query->paginate(20);

            return Response::buildSuccess(
                ['list' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }


    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'user_input' => 'required|string',
            'output_text' => 'required|string',
            'output_file_path' => 'required|string',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            DB::table(DatabaseConst::TEXT_GENERATION_HISTORY)->insert([
                'user_input' => $data->user_input,
                'output_text' => $data->output_text,
                'output_file_path' => $data->output_file_path,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }


    public function getById(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::TEXT_GENERATION_HISTORY . ' as tgh')
                ->join(DatabaseConst::USER . ' as u', 'tgh.created_by', '=', 'u.id')
                ->where('tgh.id', $id)
                ->whereNull('tgh.deleted_at')
                ->select(
                    'tgh.id',
                    'tgh.user_input',
                    'tgh.output_text',
                    'tgh.output_file_path',
                    'u.name as created_by_name',
                    'tgh.type',
                    'tgh.created_at',
                    'tgh.updated_at',
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data riwayat generasi teks tidak ditemukan');
            }

            return Response::buildSuccess(
                ['data' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::TEXT_GENERATION_HISTORY)
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                ]);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }
}

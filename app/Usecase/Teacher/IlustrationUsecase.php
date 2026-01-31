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

class IlustrationUsecase extends Usecase
{

    public function getAll(array $filterData = []): array
    {
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $query = DB::table(DatabaseConst::IMAGE_GENERATION_HISTORIES . ' as igh')
                ->where('igh.created_by', $userId)
                ->whereNull('igh.deleted_at')
                ->join(DatabaseConst::PROMPT_IMAGE_GENERATION.' as pig', 'igh.image_style_id', '=', 'pig.id')
                ->select(
                    'igh.id',
                    'igh.user_input',
                    'igh.image_style_id',
                    'igh.output_file_path',
                    'pig.name as image_style_name',
                    'igh.created_at',
                )
                ->orderBy('igh.created_at', 'desc');

            if (!empty($filterData['keywords'])) {
                $query->where('igh.user_input', 'like', '%' . $filterData['keywords'] . '%')->orWhere('igh.output_text', 'like', '%' . $filterData['keywords'] . '%');
            }
            if(!empty($filterData['image_style_id']) && $filterData['image_style_id'] != 'all'){ 
                $query->where('igh.image_style_id', $filterData['image_style_id']);
            }

            $data = $query->paginate(8);

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
            $data = DB::table(DatabaseConst::IMAGE_GENERATION_HISTORIES . ' as igh')
                ->join(DatabaseConst::USER . ' as u', 'igh.created_by', '=', 'u.id')
                ->join(DatabaseConst::PROMPT_IMAGE_GENERATION.' as pig', 'igh.image_style_id', '=', 'pig.id')
                ->where('igh.id', $id)
                ->whereNull('igh.deleted_at')
                ->select(
                    'igh.id',
                    'igh.user_input',
                    'igh.output_file_path',
                    'u.name as created_by_name',
                    'pig.name as image_style_name',
                    'igh.created_at',
                    'igh.updated_at',
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data riwayat generasi ilustrasi tidak ditemukan');
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

<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TextPromptUsecase
{
    public function getAll(){
        try {
            $data = DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->get();

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

    public function getById($id){
        try {
            $data = DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
                ->whereNull('deleted_at')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return Response::buildError(ResponseConst::HTTP_NOT_FOUND, 'Text prompt not found.');
            }

            return Response::buildSuccess(
                [
                    'item' => $data,
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

    public function create(Request $data): array{
        $validator = Validator::make($data->all(), [
            'text_prompt' => 'required|string',
            'categories' => 'required|string',
        ]);

        $validator->validate();

        if (! Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }
        DB::beginTransaction();
        try {
            $payload = $data->only(['text_prompt', 'categories']);
            $payload['created_by'] = Auth::user()?->id;
            $payload['created_at'] = now();
            $payload['updated_at'] = now();

            DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)->insert($payload);

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

    public function update(Request $data, int $id): array{
        $validator = Validator::make($data->all(), [
            'text_prompt' => 'required|string',
            'categories' => 'required|string',
        ]);

        $validator->validate();

        if (! Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }
        DB::beginTransaction();

        try {
            $payload = $data->only(['text_prompt', 'categories']);
            $payload['updated_by'] = Auth::user()?->id;
            $payload['updated_at'] = now();

            DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
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

    public function delete(int $id): array{
        if (! Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }
        DB::beginTransaction();

        try {
            DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'updated_by' => Auth::user()?->id,
                    'updated_at' => now(),
                ]);

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
}

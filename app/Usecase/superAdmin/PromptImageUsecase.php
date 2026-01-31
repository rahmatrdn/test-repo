<?php

namespace App\Usecase\superAdmin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PromptImageUsecase
{
    public function getAll(array $filterData = []): array
    {
        try {
            $query = DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
                ->whereNull('deleted_at')
                ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                    return $query->where('name', 'like', '%' . $keywords . '%');
                })
                ->orderBy('created_at', 'desc');

            if (! empty($filterData['no_pagination'])) {
                $data = $query->get();
            } else {
                $data = $query->paginate(20);

                // Append filter parameters to pagination links
                if (! empty($filterData)) {
                    $data->appends($filterData);
                }
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
            $data = DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
                ->whereNull('deleted_at')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound(
                    "Image style not found!"
                );
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

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'name'  => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'prompt' => 'required|string'
        ]);

        $validator->validate();

        if (!Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $disk = Storage::disk('public');
            $directory = 'image-models';

            if (!$disk->exists($directory)) {
                $disk->makeDirectory($directory);
            }

            $file = $data->file('image');
            $fileName = uniqid('img_') . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($directory, $fileName, 'public');

            DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)->insert([
                'name' => $data->name,
                'prompt' => $data->prompt,
                'preview_path' => '/storage/' . $path,
                'created_by' => Auth::user()?->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $request, int $id): array
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'prompt' => 'nullable|string'
        ]);

        $validator->validate();

        if (!Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $existing = DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$existing) {
                return Response::buildError(ResponseConst::HTTP_NOT_FOUND, 'Image model not found.');
            }

            $payload = [
                'name' => $request->name ?? $existing->name,
                'prompt' => $request->prompt ?? $existing->prompt,
                'updated_by' => Auth::user()?->id,
                'updated_at' => now(),
            ];

            if ($request->hasFile('image')) {
                if ($existing->preview_path) {
                    $oldPath = str_replace('/storage/', '', $existing->preview_path);
                    Storage::disk('public')->delete($oldPath);
                }

                $file = $request->file('image');
                $fileName = uniqid('img_') . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('image-models', $fileName, 'public');

                $payload['preview_path'] = '/storage/' . $path;
            }

            DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
                ->where('id', $id)
                ->update($payload);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        if (!Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $data = DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$data) {
                return Response::buildError(ResponseConst::HTTP_NOT_FOUND, 'Image model not found.');
            }

            if ($data->preview_path) {
                $path = str_replace('/storage/', 'public/', $data->preview_path);
                Storage::delete($path);
            }

            DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => now(),
                    'deleted_by' => Auth::user()->id,
                ]);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }
}

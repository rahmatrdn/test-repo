<?php

namespace App\Http\Controllers\Teacher;

use App\Constants\DatabaseConst;
use App\Http\Controllers\Controller;
use App\Http\Presenter\Response;
use App\Jobs\RunTextGeneration;
use App\Jobs\RunImageGeneration;
use App\Jobs\RunQuizGeneration;
use App\Usecase\Teacher\ImageGenerationUsecase;
use Exception;
use App\Usecase\superAdmin\TextGenerationUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToolsController extends Controller
{
    public function doCreateMateri(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'categories' => 'required|string|exists:prompt_text_generation,categories',
        ]);


        $referenceId = Str::uuid()->toString();

        RunTextGeneration::dispatch(
            referenceId: $referenceId,
            description: $request->description,
            categories: $request->categories
        );

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status_url'   => route('job_status_text', ['referenceId' => $referenceId]),
                ],
                message: 'Text generation job queued successfully'
            ),
            202
        );
    }

    public function doCreateQuiz(Request $request)
    {
        $request->validate([
            'quiz_name'       => 'required|string|max:255',
            'timer'           => 'required|string',
            'description'     => 'nullable|string',
            'topic' => 'required|string|max:255',
            'total_questions' => 'required|integer|min:1|max:50',
            'education_level' => 'required|string|in:SD,SMP,SMA,SMK',
            'class' => 'required|string|max:10',
            'options_count' => 'required|integer|min:2|max:6',
            'categories' => 'required|string|exists:prompt_text_generation,categories',
        ]);

        $userId = Auth::id();
        $referenceId = Str::uuid()->toString();

        RunQuizGeneration::dispatch(
            quizName: $request->quiz_name,
            timer: $request->timer,
            description: $request->description,
            topic: $request->topic,
            totalQuestions: (int) $request->total_questions,
            userId: (int)$userId,
            educationLevel: $request->education_level,
            class: $request->class,
            optionsCount: (int) $request->options_count,
            categories: $request->categories,
            referenceId: $referenceId,
        );

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status_url'   => route('job_status_text', ['referenceId' => $referenceId]),
                ],
                message: 'Quiz generation job queued successfully'
            ),
            202
        );
    }

    public function doCreate(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'image_style_id' => 'nullable|integer|exists:prompt_image_generation,id',
        ]);

        $referenceId = Str::uuid()->toString();

        RunImageGeneration::dispatch(
            description: $request->description,
            referenceId: $referenceId,
            imageStyleId: $request->image_style_id,
        );

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status_url' => route('job_status_image', ['referenceId' => $referenceId]),
                ],
                message: 'Image generation job queued successfully'
            ),
            202
        );
    }

    public function JobTextstatus(string $referenceId)
    {
        // 1. Check if completed
        $completedPath = "generated-texts/{$referenceId}.json";
        if (Storage::disk('local')->exists($completedPath)) {
            $data = json_decode(Storage::disk('local')->get($completedPath), true);


            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'completed',
                        'content' => $data['content'] ?? null,
                        'usage' => $data['usage'] ?? null,
                        'generated_at' => $data['generated_at'] ?? null,
                    ],
                    message: 'Text generation completed'
                )
            );
        }

        // 2. Check if failed
        $failedPath = "failed-text-generations/{$referenceId}.json";
        if (Storage::disk('local')->exists($failedPath)) {
            $errorData = json_decode(Storage::disk('local')->get($failedPath), true);

            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'failed',
                        'error' => $errorData['error'] ?? 'Unknown error',
                        'failed_at' => $errorData['timestamp'] ?? null,
                    ],
                    message: 'Text generation failed'
                ),
                500
            );
        }

        // 3. Check if job still in queue or processing
        $jobExists = DB::table('jobs')
            ->where('payload', 'like', '%' . $referenceId . '%')
            ->exists();

        if ($jobExists) {
            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'queued',
                    ],
                    message: 'Text generation is queued'
                ),
                202
            );
        }

        // 4. Job not found anywhere (might be processing or lost)
        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status' => 'processing',
                ],
                message: 'Text generation is processing'
            ),
            202
        );
    }

    public function JobImageStatus(string $referenceId)
    {
        // 1. Check if completed
        $imagePath = "generated-images/{$referenceId}.png";
        if (Storage::disk('public')->exists($imagePath)) {
            $fileSize = Storage::disk('public')->size($imagePath);
            $lastModified = Storage::disk('public')->lastModified($imagePath);

            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'completed',
                        'image_url' => Storage::url($imagePath),
                        'size_bytes' => $fileSize,
                        'generated_at' => date('Y-m-d H:i:s', $lastModified),
                    ],
                    message: 'Image generation completed'
                )
            );
        }

        // 2. Check if failed
        $failedPath = "failed-image-generations/{$referenceId}.json";
        if (Storage::disk('public')->exists($failedPath)) {
            $errorData = json_decode(Storage::disk('public')->get($failedPath), true);

            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'failed',
                        'error' => $errorData['error'] ?? 'Unknown error',
                        'failed_at' => $errorData['timestamp'] ?? null,
                    ],
                    message: 'Image generation failed'
                ),
                500
            );
        }

        // 3. Check if job still in queue
        $jobExists = DB::table('jobs')
            ->where('payload', 'like', '%' . $referenceId . '%')
            ->exists();

        if ($jobExists) {
            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'queued',
                    ],
                    message: 'Image generation is queued'
                ),
                202
            );
        }

        // 4. Job not found anywhere (might be processing or lost)
        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status' => 'processing',
                ],
                message: 'Image generation is processing'
            ),
            202
        );
    }

    public function saveHistory(Request $request)
    {
        $request->validate([
            'reference_id' => 'required|string',
            'description' => 'required|string',
            'image_style_id' => 'required|integer|exists:prompt_image_generation,id',
            'image_url' => 'required|string',
        ]);

        try {
            $imagePath = $request->image_url;

            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $imagePath = parse_url($imagePath, PHP_URL_PATH);
                $imagePath = str_replace('/storage/', '', $imagePath);
            }

            $usecase = app(ImageGenerationUsecase::class);
            $usecase->addHistory(
                modelId: $request->image_style_id,
                description: $request->description,
                imagePath: $imagePath,
                referenceId: $request->reference_id,
                userId: Auth::id(),
            );
            return response()->json(
                Response::buildSuccess(
                    message: 'History saved successfully'
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                Response::buildErrorService(
                    message: 'Failed to save history: ' . $e->getMessage()
                ),
                500
            );
        }
    }

    public function saveTextHistory(Request $request)
    {
        $request->validate([
            'reference_id' => 'required|string',
        ]);

        try {
            $referenceId = $request->reference_id;
            $completedPath = "generated-texts/{$referenceId}.json";

            if (!Storage::disk('local')->exists($completedPath)) {
                return response()->json(
                    Response::buildErrorNotFound(
                        message: 'Text generation not found or not completed yet'
                    ),
                    404
                );
            }

            $data = json_decode(Storage::disk('local')->get($completedPath), true);

            $usecase = app(TextGenerationUsecase::class);
            $usecase->addHistory($data, $completedPath);

            return response()->json(
                Response::buildSuccess(
                    message: 'Text generation history saved successfully'
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                Response::buildErrorService(
                    message: 'Failed to save text history: ' . $e->getMessage()
                ),
                500
            );
        }
    }
}

<?php

namespace App\Usecase\Teacher;

use App\Constants\AIConst;
use App\Constants\DatabaseConst;
use App\Constants\PromptConst;
use App\Http\Presenter\Response;
use App\Usecase\superAdmin\ToolsAiUsecase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageGenerationUsecase
{
    private ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }

    /**
     * Generate image using AI and save with reference_id as filename
     *
     * @param string $prompt The prompt for image generation
     * @param string $referenceId Unique reference ID (akan jadi nama file)
     * @return array Response with image_path and status
     */
    private function generate(string $prompt, string $referenceId): array
    {
        try {
            $apiKey = $this->aiToolsUsecase->getApikeys('gemini');
            $url = AIConst::getUrlImageGeneration(
                AIConst::IMAGE_MODEL,
                $apiKey
            );

            $payload = [
                "contents" => [[
                    "role" => "user",
                    "parts" => [["text" => $prompt]]
                ]],
                "generationConfig" => [
                    "responseModalities" => ["IMAGE"]
                ]
            ];

            $data = $this->aiToolsUsecase->makeRequest($url, $payload);
            $imageData = $this->aiToolsUsecase->extractImageFromResponse($data);

            if (!isset($imageData['data']) || empty($imageData['data'])) {
                throw new \RuntimeException('No image data received from API');
            }

            $path = "generated-images/{$referenceId}.png";

            $decodedImage = base64_decode($imageData['data'], true);

            if ($decodedImage === false) {
                throw new \RuntimeException('Failed to decode base64 image data');
            }

            $saved = Storage::disk('public')->put($path, $decodedImage);

            if (!$saved) {
                throw new \RuntimeException('Failed to save image to storage');
            }

            $publicUrl = asset('storage/' . $path);

            return Response::buildSuccess([
                'image_path' => $path,
                'reference_id' => $referenceId,
                'url' => $publicUrl,
                'size_bytes' => strlen($decodedImage)
            ], 200, 'Image generated successfully');
        } catch (\Throwable $e) {
            return Response::buildErrorService(
                'Failed to generate image: ' . $e->getMessage()
            );
        }
    }

    /**
     * Add image generation history record
     */
    public function addHistory(int $modelId, string $description, string $imagePath, string $referenceId, ?int $userId = null): void
    {
        $finalUserId = $userId ?? Auth::id() ?? Auth::guard('web')->id();

        if (!$finalUserId) {
            throw new \RuntimeException('User must be authenticated to save history');
        }

        DB::table(DatabaseConst::IMAGE_GENERATION_HISTORIES)->insert([
            'user_input' => $description,
            'image_style_id' => $modelId,
            'reference' => $referenceId,
            'output_file_path' => $imagePath,
            'created_at' => now(),
            'created_by' => $finalUserId,
        ]);
    }

    /**
     * Generate generic image from description
     */
    public function generateIlustration(string $description, string $referenceId, int $modelId): array
    {
        $imageModel = DB::table(DatabaseConst::PROMPT_IMAGE_GENERATION)
            ->where('id', $modelId)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->first();

        if (!$imageModel) {
            return Response::buildErrorService('Invalid image model ID provided.');
        }

        $prompt = $this->aiToolsUsecase->resolver(
            $imageModel->prompt,
            ['description' => $description]
        );

        return $this->generate($prompt, $referenceId);
    }
}

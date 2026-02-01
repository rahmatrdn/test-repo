<?php

namespace App\Jobs;

use App\Usecase\Teacher\ImageGenerationUsecase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class RunImageGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = [10, 30, 60];

    public function __construct(
        public string $referenceId,
        public string $description,
        public int $imageStyleId,
    ) {}

    public function handle(): void
    {
        try {
            $usecase = app(abstract: ImageGenerationUsecase::class);
            $result = $usecase->generateIlustration(
                description: $this->description,
                referenceId: $this->referenceId,
                modelId: $this->imageStyleId,
            );

            dump($result);

            if (($result['code'] ?? null) !== 200) {
                if (Storage::disk('public')->exists("generated-images/{$this->referenceId}.png")) {
                    Log::warning('Job marked failed but image exists', [
                        'reference_id' => $this->referenceId
                    ]);
                    return;
                }

                throw new RuntimeException(
                    $result['message'] ?? 'Image generation failed'
                );
            }
        } catch (Throwable $e) {
            Log::error('RunImageGeneration FAILED', [
                'reference_id' => $this->referenceId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Storage::disk('public')->put(
            "failed-image-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'description' => $this->description,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );
    }
}

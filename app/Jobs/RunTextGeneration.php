<?php

namespace App\Jobs;

use App\Usecase\SuperAdmin\TextGenerationUsecase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class RunTextGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = 30;

    public function __construct(
        public string $description,
        public string $categories,
        public string $referenceId,
    ) {}

    public function handle(): void
    {
        try {
            $usecase = app(TextGenerationUsecase::class);

            $result = $usecase->generateTextGemini(
                description: $this->description,
                categories: $this->categories
            );

            if (!($result['success'] ?? false)) {
                throw new RuntimeException(
                    $result['message'] ?? 'Text generation failed'
                );
            }

            $data = $result['data'];

            $payload = [
                'reference_id' => $this->referenceId,
                'input' => $this->description,
                'categories'   => $this->categories,
                'generated_at' => now()->toDateTimeString(),
                'content'      => $data['content'],
                'usage'        => $data['usage'],
            ];

            Storage::disk('local')->put(
                "generated-texts/{$this->referenceId}.json",
                json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            Log::info('Text generation completed', [
                'reference_id' => $this->referenceId,
                'categories' => $this->categories,
                'usage' => $data['usage']
            ]);
        } catch (Throwable $e) {
            Log::error('RunTextGeneration FAILED', [
                'reference_id' => $this->referenceId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Storage::disk('local')->put(
            "failed-text-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'categories' => $this->categories,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );

        Log::error('Job definitively FAILED after all retries', [
            'reference_id' => $this->referenceId,
            'tries' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }
}

<?php

namespace App\Jobs;

use App\UseCases\Teacher\SummarizeDocUsecase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class RunDocSummarizer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    public $tries = 2;

    protected string $storedFilePath;
    protected ?string $userPrompt;
    protected ?int $userId;
    protected string $originalFileName;
    protected string $mimeType;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $storedFilePath,
        string $originalFileName,
        string $mimeType,
        ?string $userPrompt = null,
        ?int $userId = null
    ) {
        $this->storedFilePath = $storedFilePath;
        $this->originalFileName = $originalFileName;
        $this->mimeType = $mimeType;
        $this->userPrompt = $userPrompt;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(SummarizeDocUsecase $summarizeUsecase): void
    {
        try {
            Log::info('Starting document summarization job', [
                'file' => $this->originalFileName,
                'user_id' => $this->userId
            ]);

            $filePath = Storage::path($this->storedFilePath);

            if (!file_exists($filePath)) {
                throw new \RuntimeException('Stored file not found');
            }

            // Create UploadedFile instance
            $file = new UploadedFile(
                $filePath,
                $this->originalFileName,
                $this->mimeType,
                null,
                true
            );

            // Perform summarization using Gemini File API
            $result = $summarizeUsecase->summarize($file, $this->userPrompt);

            // Add metadata
            $result['user_id'] = $this->userId;
            $result['processed_at'] = now()->toDateTimeString();

            Log::info('Document summarization completed', [
                'file' => $this->originalFileName,
                'success' => $result['success']
            ]);

            // Save result
            $this->saveResult($result);

            // Clean up
            Storage::delete($this->storedFilePath);
        } catch (\Exception $e) {
            Log::error('Document summarization failed', [
                'file' => $this->originalFileName,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if (Storage::exists($this->storedFilePath)) {
                Storage::delete($this->storedFilePath);
            }

            throw $e;
        }
    }

    protected function saveResult(array $result): void
    {
        $fileName = 'summaries/' . $this->userId . '/' . uniqid() . '_summary.json';
        Storage::put($fileName, json_encode($result, JSON_PRETTY_PRINT));

        Log::info('Summary saved', ['file' => $fileName]);
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Document summarization job failed permanently', [
            'file' => $this->originalFileName,
            'user_id' => $this->userId,
            'error' => $exception->getMessage()
        ]);

        if (Storage::exists($this->storedFilePath)) {
            Storage::delete($this->storedFilePath);
        }
    }
}

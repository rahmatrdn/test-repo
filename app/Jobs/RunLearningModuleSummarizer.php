<?php

namespace App\Jobs;

use App\Usecase\Teacher\SummarizeDocUsecase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Constants\DatabaseConst;
use Illuminate\Http\UploadedFile;

class RunLearningModuleSummarizer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    public $tries = 2;

    protected string $filePath;
    protected string $originalFileName;
    protected string $mimeType;
    protected int $learningModuleId;
    protected ?int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $filePath,
        string $originalFileName,
        string $mimeType,
        int $learningModuleId,
        ?int $userId = null
    ) {
        $this->filePath = $filePath;
        $this->originalFileName = $originalFileName;
        $this->mimeType = $mimeType;
        $this->learningModuleId = $learningModuleId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(SummarizeDocUsecase $summarizeUsecase): void
    {
        try {
            Log::info('Starting learning module summarization job', [
                'file' => $this->originalFileName,
                'learning_module_id' => $this->learningModuleId,
                'user_id' => $this->userId
            ]);

            $fullPath = Storage::disk('public')->path($this->filePath);

            if (!file_exists($fullPath)) {
                throw new \RuntimeException('File not found: ' . $fullPath);
            }

            $file = new UploadedFile(
                $fullPath,
                $this->originalFileName,
                $this->mimeType,
                null,
                true
            );

            // Perform summarization
            $result = $summarizeUsecase->summarize($file);

            if ($result && isset($result['summary'])) {
                $summary = $result['summary'];

                // Update learning module with summary
                DB::table(DatabaseConst::LEARNING_MODULE)
                    ->where('id', $this->learningModuleId)
                    ->update([
                        'summary' => $summary,
                        'updated_at' => now(),
                    ]);

                Log::info('Learning module summarization completed', [
                    'file' => $this->originalFileName,
                    'learning_module_id' => $this->learningModuleId,
                    'summary_length' => strlen($summary)
                ]);
            } else {
                Log::warning('Summarization returned no summary', [
                    'learning_module_id' => $this->learningModuleId,
                    'result' => $result
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Learning module summarization failed', [
                'file' => $this->originalFileName,
                'learning_module_id' => $this->learningModuleId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Learning module summarization job failed permanently', [
            'file' => $this->originalFileName,
            'learning_module_id' => $this->learningModuleId,
            'user_id' => $this->userId,
            'error' => $exception->getMessage()
        ]);

        // Mark as failed in database if needed
        DB::table(DatabaseConst::LEARNING_MODULE)
            ->where('id', $this->learningModuleId)
            ->update([
                'summary' => null,
                'updated_at' => now(),
            ]);
    }
}

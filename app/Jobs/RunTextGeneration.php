<?php

namespace App\Jobs;

use App\Usecase\GeminiUsecase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable; // ✅ Import Throwable

class RunTextGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = 30;

    public function __construct(
        public string $message,
        public string $referenceId,
        public string $topic,
        public string $level
    ) {}

    public function handle(GeminiUsecase $geminiUsecase): void
    {
        try {
            $generatedText = $geminiUsecase->generateText(
                $this->topic,
                $this->level
            );

            // Simpan hasil ke storage
            Storage::disk('local')->put(
                "generated-texts/{$this->referenceId}.txt",
                $generatedText
            );

            Log::info('AI Generation Succeeded', [
                'reference_id' => $this->referenceId,
                'topic' => $this->topic,
                'level' => $this->level,
                'text_length' => strlen($generatedText),
                'preview' => substr($generatedText, 0, 100) . '...',
                'attempt' => $this->attempts(),
            ]);

        } catch (Throwable $e) { // ✅ Gunakan Throwable, bukan Exception
            Log::error('AI Generation Failed', [
                'reference_id' => $this->referenceId,
                'topic' => $this->topic,
                'level' => $this->level,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     *
     * ✅ PENTING: Gunakan Throwable, bukan Exception
     */
    public function failed(Throwable $exception): void
    {
        Log::critical('AI Generation Permanently Failed', [
            'reference_id' => $this->referenceId,
            'topic' => $this->topic,
            'level' => $this->level,
            'message' => $this->message,
            'error' => $exception->getMessage(),
            'error_type' => get_class($exception), // ✅ Log tipe error
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'total_attempts' => $this->attempts(),
            'trace' => $exception->getTraceAsString(),
        ]);

        // ✅ Opsional: Simpan error log ke file terpisah
        Storage::disk('local')->put(
            "failed-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'topic' => $this->topic,
                'level' => $this->level,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );

        // ✅ Opsional: Kirim notifikasi
        // Mail::to('admin@example.com')->send(new JobFailedMail($this, $exception));
    }
}

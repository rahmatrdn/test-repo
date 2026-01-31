<?php

namespace App\Jobs;

use App\Constants\DatabaseConst;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use App\Usecase\superAdmin\TextGenerationtUsecase;
use App\Usecase\SuperAdmin\TextGenerationUsecase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class RunQuizGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 300;
    public $backoff = 30;

    public function __construct(
        public string $topic,
        public int $totalQuestions,
        public int $userId,
        public string $educationLevel,
        public string $class,
        public int $optionsCount,
        public string $categories,
        public string $referenceId,
        public string $quizName,
        public string $timer,
        public ?string $description,
    ) {}

    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $usecase = app(TextGenerationUsecase::class);
            $formattedTime = Carbon::createFromFormat('H:i', $this->timer)->format('H:i:s');
            $result = $usecase->generateQuizGemini(
                topic: $this->topic,
                total_question: $this->totalQuestions,
                education_level: $this->educationLevel,
                grade: $this->class,
                option_count: $this->optionsCount,
                categories: $this->categories,
            );

            if (!($result['success'] ?? false)) {
                throw new RuntimeException($result['message'] ?? 'Text generation failed');
            }

            $rawContent = $result['data']['content'] ?? '';

            $cleanJson = trim($rawContent);
            $cleanJson = preg_replace('/^```json\s*|```$/', '', $cleanJson);

            Storage::disk('local')->put(
                "generated-quiz/{$this->referenceId}.json",
                $cleanJson
            );

            if (preg_match('/\[.*\]/s', $cleanJson, $matches)) {
                $cleanJson = $matches[0];
            }

            $questions = json_decode($cleanJson, true);

            // Validasi JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Truncated or Invalid', [
                    'reference_id' => $this->referenceId,
                    'error' => json_last_error_msg(),
                    'raw_tail' => substr($rawContent, -50)
                ]);
                throw new RuntimeException('AI JSON terpotong atau format salah.');
            }

            $quizId = DB::table(DatabaseConst::QUIZZES)->insertGetId([
                'quiz_name'   => $this->quizName,
                'description' => $this->description,
                'quiz_code'   => substr($this->referenceId, 0, 5),
                'quiz_time'   => $formattedTime,
                'created_at'  => now(),
                'created_by'  => $this->userId,
            ]);

            foreach ($questions as $q) {
                if (!isset($q['question'], $q['options'], $q['correct_answer'])) continue;

                $questionId = DB::table(DatabaseConst::QUIZ_QUETIONS)->insertGetId([
                    'quiz_id'    => $quizId,
                    'question'   => $q['question'],
                    'created_at' => now(),
                    'created_by' => $this->userId,
                ]);

                foreach ($q['options'] as $option) {
                    DB::table(DatabaseConst::QUIZ_OPTIONS)->insert([
                        'question_id' => $questionId,
                        'option_text' => $option,
                        'is_correct'  => (trim($option) === trim($q['correct_answer'])) ? 1 : 0,
                        'created_at'  => now(),
                        'created_by'  => $this->userId,
                    ]);
                }
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('RunQuizGeneration Process Error', [
                'reference_id' => $this->referenceId,
                'message' => $e->getMessage()
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
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );
    }
}

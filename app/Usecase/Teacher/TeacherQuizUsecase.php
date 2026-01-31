<?php

namespace App\Usecase\Teacher;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TeacherQuizUsecase extends Usecase
{
    public function getAll(array $filterData = []): array
    {
        try {
            $user = Auth::user();
            if (! $user) {
                throw new Exception('User not authenticated');
            }

            $query = DB::table(DatabaseConst::QUIZ . ' as q')
                ->join(DatabaseConst::USER . ' as u', 'q.created_by', '=', 'u.id')
                ->whereNull('q.deleted_at')
                ->select(
                    'q.id',
                    'q.quiz_name',
                    'q.description',
                    'q.quiz_code',
                    'q.quiz_time',
                    'q.created_at',
                    'u.name as created_by_name'
                )
                ->selectSub(
                    DB::table(DatabaseConst::QUIZ_ATTEMPT . ' as qa')
                        ->selectRaw('COUNT(DISTINCT qa.student_id)')
                        ->whereColumn('qa.quiz_id', 'q.id')
                        ->whereNull('qa.deleted_at'),
                    'participants_count'
                )
                ->orderBy('q.created_at', 'desc');

            // Filter by school_id for multi-tenancy
            if ($user->access_type == 4) {
                $query->where('q.school_id', $user->school_id);
            } else {
                $query->where('q.created_by', $user->id);
            }

            // Search filter
            if (! empty($filterData['keywords'])) {
                $query->where('q.quiz_name', 'like', '%' . $filterData['keywords'] . '%');
            }

            // Count questions for each quiz
            $data = $query->paginate(20);

            // Add question count to each quiz
            $data->getCollection()->transform(function ($quiz) {
                $quiz->question_count = DB::table(DatabaseConst::QUIZ_QUESTION)
                    ->where('quiz_id', $quiz->id)
                    ->whereNull('deleted_at')
                    ->count();

                return $quiz;
            });

            return Response::buildSuccess(
                ['list' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|date_format:H:i:s',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            $schoolId = Auth::user()?->school_id;

            if (! $userId) {
                throw new Exception('User not authenticated');
            }

            // Generate unique 5-digit quiz code
            do {
                $quizCode = Str::upper(Str::random(5)); 
            } while (
                DB::table(DatabaseConst::QUIZ)
                ->where('quiz_code', $quizCode)
                ->exists()
            );

            // Insert quiz
            $quizId = DB::table(DatabaseConst::QUIZ)->insertGetId([
                'quiz_name' => $data->name,
                'description' => $data->description,
                'quiz_code' => $quizCode,
                'quiz_time' => $data->duration,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccess(
                ['quiz_id' => $quizId, 'quiz_code' => $quizCode],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function addQuestions(Request $data, int $quizId): array
    {
        $validator = Validator::make($data->all(), [
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;

            if (! $userId) {
                throw new Exception('User not authenticated');
            }

            // Verify quiz exists and user has permission
            $quiz = DB::table(DatabaseConst::QUIZ)
                ->where('id', $quizId)
                ->whereNull('deleted_at')
                ->first();

            if (! $quiz) {
                throw new Exception('Quiz not found');
            }

            // Insert questions and options
            foreach ($data->questions as $questionData) {
                $questionId = DB::table(DatabaseConst::QUIZ_QUESTION)->insertGetId([
                    'quiz_id' => $quizId,
                    'question' => $questionData['question'],
                    'created_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert options (A-E)
                $options = ['A', 'B', 'C', 'D', 'E'];
                foreach ($options as $option) {
                    $optionKey = 'option_' . strtolower($option);

                    // Only insert if option text is provided
                    if (! empty($questionData[$optionKey])) {
                        DB::table(DatabaseConst::QUIZ_OPTION)->insert([
                            'question_id' => $questionId,
                            'option_text' => $questionData[$optionKey],
                            'is_correct' => $questionData['correct_answer'] === $option ? 1 : 0,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getById(int $id): array
    {
        try {
            $user = Auth::user();
            if (! $user) {
                throw new Exception('User not authenticated');
            }

            // Get quiz
            $quiz = DB::table(DatabaseConst::QUIZ . ' as q')
                ->join(DatabaseConst::USER . ' as u', 'q.created_by', '=', 'u.id')
                ->where('q.id', $id)
                ->whereNull('q.deleted_at')
                ->select(
                    'q.*',
                    'u.name as created_by_name'
                )
                ->first();

            if (! $quiz) {
                return Response::buildErrorNotFound('Data kuis tidak ditemukan');
            }

            // Get questions with options
            $questions = DB::table(DatabaseConst::QUIZ_QUESTION . ' as qq')
                ->where('qq.quiz_id', $id)
                ->whereNull('qq.deleted_at')
                ->select('qq.*')
                ->orderBy('qq.id')
                ->get();

            // Get options for each question
            foreach ($questions as $question) {
                $options = DB::table(DatabaseConst::QUIZ_OPTION)
                    ->where('question_id', $question->id)
                    ->whereNull('deleted_at')
                    ->orderBy('id')
                    ->get();

                $question->options = $options;
            }

            $quiz->questions = $questions;

            return Response::buildSuccess(
                ['data' => $quiz],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            if (! $userId) {
                throw new Exception('User not authenticated');
            }

            // Check if quiz exists
            $quiz = DB::table(DatabaseConst::QUIZ)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (! $quiz) {
                throw new Exception('Data kuis tidak ditemukan');
            }

            // 1. Update quiz
            DB::table(DatabaseConst::QUIZ)
                ->where('id', $id)
                ->update([
                    'quiz_name' => $data->name,
                    'description' => $data->description,
                    'quiz_time' => $data->duration ?? 60,
                    'updated_by' => $userId,
                    'updated_at' => now(),
                ]);

            // 2. Soft delete existing questions and options
            DB::table(DatabaseConst::QUIZ_QUESTION)
                ->where('quiz_id', $id)
                ->update([
                    'deleted_by' => $userId,
                    'deleted_at' => now(),
                ]);

            $existingQuestionIds = DB::table(DatabaseConst::QUIZ_QUESTION)
                ->where('quiz_id', $id)
                ->pluck('id');

            if ($existingQuestionIds->isNotEmpty()) {
                DB::table(DatabaseConst::QUIZ_OPTION)
                    ->whereIn('question_id', $existingQuestionIds)
                    ->update([
                        'deleted_by' => $userId,
                        'deleted_at' => now(),
                    ]);
            }

            // 3. Insert new questions and options
            foreach ($data->questions as $questionData) {
                $questionId = DB::table(DatabaseConst::QUIZ_QUESTION)->insertGetId([
                    'quiz_id' => $id,
                    'question' => $questionData['question'],
                    'created_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert options
                $options = ['A', 'B', 'C', 'D', 'E'];
                foreach ($options as $option) {
                    $optionKey = 'option_' . strtolower($option);

                    if (! empty($questionData[$optionKey])) {
                        DB::table(DatabaseConst::QUIZ_OPTION)->insert([
                            'question_id' => $questionId,
                            'option_text' => $questionData[$optionKey],
                            'is_correct' => $questionData['correct_answer'] === $option ? 1 : 0,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            if (! $userId) {
                throw new Exception('User not authenticated');
            }

            // Check if quiz exists
            $quiz = DB::table(DatabaseConst::QUIZ)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (! $quiz) {
                throw new Exception('Data kuis tidak ditemukan');
            }

            // 1. Soft delete quiz
            DB::table(DatabaseConst::QUIZ)
                ->where('id', $id)
                ->update([
                    'deleted_by' => $userId,
                    'deleted_at' => now(),
                ]);

            // 2. Soft delete questions
            DB::table(DatabaseConst::QUIZ_QUESTION)
                ->where('quiz_id', $id)
                ->update([
                    'deleted_by' => $userId,
                    'deleted_at' => now(),
                ]);

            // 3. Soft delete options
            $questionIds = DB::table(DatabaseConst::QUIZ_QUESTION)
                ->where('quiz_id', $id)
                ->pluck('id');

            if ($questionIds->isNotEmpty()) {
                DB::table(DatabaseConst::QUIZ_OPTION)
                    ->whereIn('question_id', $questionIds)
                    ->update([
                        'deleted_by' => $userId,
                        'deleted_at' => now(),
                    ]);
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getScoresByQuizId(int $quizId)
    {
        try {
            $data = DB::table('quiz_attempts as qa')
                ->join('quiz_results as qr', 'qa.id', '=', 'qr.quiz_attempt_id')
                ->join('users as u', 'qa.student_id', '=', 'u.id')
                ->select([
                    'qa.id',
                    'qa.student_id',
                    'qa.quiz_id',
                    'qa.started_at',
                    'qa.finished_at',
                    'u.name as student_name',
                    'qr.working_time',
                    'qr.correct_answer',
                    'qr.wrong_answer',
                    'qr.score',
                    DB::raw('qa.finished_at as completed_at'),
                    DB::raw('(qr.correct_answer + qr.wrong_answer) as total_questions'),
                    DB::raw('qr.correct_answer as correct_answers')
                ])
                ->where('qa.quiz_id', $quizId)
                ->whereNull('qa.deleted_at')
                ->whereNull('qr.deleted_at')
                ->whereIn('qa.id', function ($query) use ($quizId) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('quiz_attempts')
                        ->where('quiz_id', $quizId)
                        ->groupBy('student_id');
                })
                ->orderBy('qa.created_at', 'desc')
                ->paginate(15);

            return Response::buildSuccess(['list' => $data]);
        } catch (Exception $e) {
            return Response::buildErrorService($e->getMessage());
        }
    }
}

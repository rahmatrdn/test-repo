<?php

namespace App\Usecase;

use Illuminate\Support\Facades\DB;
use App\Constants\DatabaseConst;
use Exception;

class QuizUsecase
{
    // public function getQuizForSoalByQuizId(int $quizId): array
    // {
    //     try {
    //         // 1️⃣ Ambil quiz
    //         $quiz = DB::table(DatabaseConst::QUIZ)
    //             ->where('id', $quizId)
    //             ->whereNull('deleted_at')
    //             ->first();

    //         if (! $quiz) {
    //             return [
    //                 'success' => false,
    //                 'message' => 'Quiz tidak ditemukan',
    //                 'data'    => null
    //             ];
    //         }

    //         // 2️⃣ Ambil questions
    //         $questions = DB::table(DatabaseConst::QUIZ_QUESTION)
    //             ->where('quiz_id', $quizId)
    //             ->whereNull('deleted_at')
    //             ->get();

    //         if ($questions->isEmpty()) {
    //             return [
    //                 'success' => true,
    //                 'message' => 'Quiz tanpa soal',
    //                 'data'    => [
    //                     'quiz' => $quiz,
    //                     'questions' => []
    //                 ]
    //             ];
    //         }

    //         // 3️⃣ Ambil options berdasarkan question_id
    //         $questionIds = $questions->pluck('id')->toArray();

    //         $options = DB::table(DatabaseConst::QUIZ_OPTIONS)
    //             ->whereIn('question_id', $questionIds)
    //             ->whereNull('deleted_at')
    //             ->get()
    //             ->groupBy('question_id');

    //         // 4️⃣ Gabungkan question + options
    //         $formattedQuestions = $questions->map(function ($question) use ($options) {
    //             return [
    //                 'id'       => $question->id,
    //                 'question' => $question->question,
    //                 'options'  => $options[$question->id] ?? []
    //             ];
    //         });

    //         return [
    //             'success' => true,
    //             'message' => 'Berhasil mengambil data quiz',
    //             'data'    => [
    //                 'quiz'      => $quiz,
    //                 'questions' => $formattedQuestions
    //             ]
    //         ];
    //     } catch (Exception $e) {
    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //             'data'    => null
    //         ];
    //     }
    // }

    // public function getQuizByQuizId(int $quizId): array
    // {
    //     try {
    //         // 1️⃣ Ambil quiz
    //         $quiz = DB::table(DatabaseConst::QUIZ)
    //             ->where('id', $quizId)
    //             ->whereNull('deleted_at')
    //             ->first();

    //         if (! $quiz) {
    //             return [
    //                 'success' => false,
    //                 'message' => 'Quiz tidak ditemukan',
    //                 'data'    => null
    //             ];
    //         }

    //         return [
    //             'success' => true,
    //             'message' => 'Berhasil mengambil data quiz',
    //             'data'    => $quiz
    //         ];
    //     } catch (Exception $e) {
    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //             'data'    => null
    //         ];
    //     }
    // }

    // public function checkQuizResult(int $quizId, array $results): array
    // {
    //     return DB::transaction(function () use ($quizId, $results) {

    //         $totalSoal  = count($results);
    //         $benar      = 0;
    //         $salah      = 0;
    //         $detail     = [];

    //         foreach ($results as $result) {

    //             $questionId = $result['question_id'] ?? null;
    //             $optionId   = $result['selected_option_id'] ?? null;

    //             if (!$questionId || !$optionId) {
    //                 continue;
    //             }

    //             /**
    //              * 1. Validasi question milik quiz
    //              */
    //             $questionExists = DB::table('quiz_questions')
    //                 ->where('id', $questionId)
    //                 ->where('quiz_id', $quizId)
    //                 ->exists();

    //             if (!$questionExists) {
    //                 continue;
    //             }

    //             /**
    //              * 2. Ambil opsi jawaban
    //              */
    //             $option = DB::table('quiz_options')
    //                 ->where('id', $optionId)
    //                 ->where('question_id', $questionId) // 🔥 relasi ke quiz_questions
    //                 ->first();

    //             $isCorrect = ($option && $option->is_correct == 1);

    //             if ($isCorrect) {
    //                 $benar++;
    //             } else {
    //                 $salah++;
    //             }

    //             $detail[] = [
    //                 'question_id' => $questionId,
    //                 'selected_option_id' => $optionId,
    //                 'is_correct' => $isCorrect,
    //                 'is_uncertain' => $result['is_uncertain'] ?? false,
    //             ];
    //         }

    //         return [
    //             'total' => $totalSoal,
    //             'benar' => $benar,
    //             'salah' => $salah,
    //             'nilai' => $totalSoal > 0
    //                 ? round(($benar / $totalSoal) * 100)
    //                 : 0,
    //             'detail' => $detail,
    //         ];
    //     });
    // }
}

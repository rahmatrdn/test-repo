<?php

namespace App\Usecase\Student;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuizUsecase extends Usecase
{
    public function getAll(array $filterData = []): array
    {
        try {
            $user = Auth::user();
            if (!$user) {
                throw new Exception('User tidak terautentikasi');
            }

            $query = DB::table(DatabaseConst::QUIZ_RESULT . ' as qr')
                // Join ke Attempt untuk mengunci kepemilikan data (student_id)
                ->join(DatabaseConst::QUIZ_ATTEMPT . ' as qa', 'qr.quiz_attempt_id', '=', 'qa.id')
                // Join ke Master Kuis untuk informasi judul
                ->join(DatabaseConst::QUIZ . ' as q', 'qa.quiz_id', '=', 'q.id')
                // Join ke Mata Pelajaran
                ->join(DatabaseConst::SUBJECT . ' as s', 'q.subject_id', '=', 's.id')

                // Filter Utama: Hanya data milik siswa yang sedang login
                ->where('qa.student_id', $user->id)
                ->whereNull('qr.deleted_at')
                ->whereNull('qa.deleted_at')

                ->select(
                    'qr.id',
                    'q.title as quiz_title',
                    's.name as subject_name',
                    'qr.working_time',   // Durasi pengerjaan
                    'qr.correct_answer', // Jumlah benar
                    'qr.wrong_answer',   // Jumlah salah
                    'qr.score',          // Nilai akhir
                    'qa.started_at',     // Waktu mulai
                    'qa.finished_at',    // Waktu selesai
                    'qr.created_at'      // Tanggal submit
                )
                ->orderBy('qr.created_at', 'desc');

            // Filter Pencarian berdasarkan Judul Kuis atau Mapel
            if (!empty($filterData['keywords'])) {
                $query->where(function ($q) use ($filterData) {
                    $q->where('q.title', 'like', '%' . $filterData['keywords'] . '%')
                        ->orWhere('s.name', 'like', '%' . $filterData['keywords'] . '%');
                });
            }

            // Filter per Mata Pelajaran (jika ada dropdown filter di UI)
            if (!empty($filterData['subject_id']) && $filterData['subject_id'] != 'all') {
                $query->where('q.subject_id', $filterData['subject_id']);
            }

            $data = $query->paginate(20);

            return Response::buildSuccess(
                ['list' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService('Gagal memuat data riwayat kuis.');
        }
    }


    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'title' => 'required|string|max:255',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,webp,png,jpg,jpeg|max:20480',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $file = $data->file('file');

            $extension = $file->getClientOriginalExtension();

            $subject = DB::table(DatabaseConst::SUBJECT)
                ->where('id', $data->subject_id)
                ->first();
            $subjectName = $subject ? str_replace(' ', '_', $subject->name) : 'unknown';

            $fileName = date('Ymd') . '-' . $subjectName . '-' . str_replace(' ', '_', $data->title) . '.' . $extension;

            $filePath = Storage::disk('public')->putFileAs(
                'learning_modules',
                $file,
                $fileName
            );

            DB::table(DatabaseConst::LEARNING_MODULE)->insert([
                'title' => $data->title,
                'subject_id' => $data->subject_id,
                'classroom' => $data->classroom,
                'file_path' => $filePath,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
                'school_id' => Auth::user()?->school_id,
            ]);

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
            $data = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SUBJECT . ' as s', 'lm.subject_id', '=', 's.id')
                ->join(DatabaseConst::USER . ' as u', 'lm.created_by', '=', 'u.id')
                ->where('lm.id', $id)
                ->whereNull('lm.deleted_at')
                ->select(
                    'lm.id',
                    'lm.title',
                    'lm.classroom',
                    'lm.file_path',
                    's.name as subject_name',
                    'u.name as created_by_name',
                    'lm.created_at',
                    'lm.updated_at',
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data modul pembelajaran tidak ditemukan');
            }

            return Response::buildSuccess(
                ['data' => $data],
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
            'title' => 'required|string|max:255',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom' => 'required|string|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->update([
                    'title' => $data->title,
                    'subject_id' => $data->subject_id,
                    'classroom' => $data->classroom,
                    'file_path' => $data->file ? $data->file->store('learning_modules') : DB::raw('file_path'),
                    'updated_at' => now(),
                ]);

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
            DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                ]);

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

    public function getQuizForSoalByQuizId(string $code): array
    {
        try {
            // 1️⃣ Ambil quiz
            $quiz = DB::table(DatabaseConst::QUIZ)
                ->where('quiz_code', $code)
                ->whereNull('deleted_at')
                ->first();

            if (! $quiz) {
                return [
                    'success' => false,
                    'message' => 'Quiz tidak ditemukan',
                    'data'    => null
                ];
            }

            $quizId = $quiz->id;

            // 2️⃣ Ambil questions
            $questions = DB::table(DatabaseConst::QUIZ_QUESTION)
                ->where('quiz_id', $quizId)
                ->whereNull('deleted_at')
                ->get();

            if ($questions->isEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Quiz tanpa soal',
                    'data'    => [
                        'quiz' => $quiz,
                        'questions' => []
                    ]
                ];
            }

            // 3️⃣ Ambil options berdasarkan question_id
            $questionIds = $questions->pluck('id')->toArray();

            $options = DB::table(DatabaseConst::QUIZ_OPTION)
                ->whereIn('question_id', $questionIds)
                ->whereNull('deleted_at')
                ->get()
                ->groupBy('question_id');

            // 4️⃣ Gabungkan question + options
            $formattedQuestions = $questions->map(function ($question) use ($options) {
                return [
                    'id'       => $question->id,
                    'question' => $question->question,
                    'options'  => $options[$question->id] ?? []
                ];
            });

            return [
                'success' => true,
                'message' => 'Berhasil mengambil data quiz',
                'data'    => [
                    'quiz'      => $quiz,
                    'questions' => $formattedQuestions
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => null
            ];
        }
    }

    public function getQuizByQuizId(int $quizId): array
    {
        try {
            // 1️⃣ Ambil quiz
            $quiz = DB::table(DatabaseConst::QUIZ)
                ->where('id', $quizId)
                ->whereNull('deleted_at')
                ->first();

            if (! $quiz) {
                return [
                    'success' => false,
                    'message' => 'Quiz tidak ditemukan',
                    'data'    => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Berhasil mengambil data quiz',
                'data'    => $quiz
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => null
            ];
        }
    }

    public function getByQuizCode(string $quizCode): array
    {
        try {
            // 1️⃣ Ambil quiz
            $quiz = DB::table(DatabaseConst::QUIZ)
                ->where('quiz_code', $quizCode)
                ->whereNull('deleted_at')
                ->first();

            if (! $quiz) {
                return [
                    'success' => false,
                    'message' => 'Quiz tidak ditemukan',
                    'data'    => null
                ];
            }

            // 2️⃣ Hitung jumlah soal
            $totalSoal = DB::table(DatabaseConst::QUIZ_QUESTION)
                ->where('quiz_id', $quiz->id)
                ->whereNull('deleted_at')
                ->count();

            // 3️⃣ Tambahkan info ke response
            $quiz->total_soal = $totalSoal;
            $quiz->has_soal   = $totalSoal > 0;

            return [
                'success' => true,
                'message' => 'Berhasil mengambil data quiz',
                'data'    => $quiz
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => null
            ];
        }
    }


    public function checkQuizResult(int $quizId, array $results): array
    {
        return DB::transaction(function () use ($quizId, $results) {

            $totalSoal  = count($results);
            $benar      = 0;
            $salah      = 0;
            $detail     = [];

            foreach ($results as $result) {

                $questionId = $result['question_id'] ?? null;
                $optionId   = $result['selected_option_id'] ?? null;

                if (!$questionId || !$optionId) {
                    continue;
                }

                /**
                 * 1. Validasi question milik quiz
                 */
                $questionExists = DB::table('quiz_questions')
                    ->where('id', $questionId)
                    ->where('quiz_id', $quizId)
                    ->exists();

                if (!$questionExists) {
                    continue;
                }

                /**
                 * 2. Ambil opsi jawaban
                 */
                $option = DB::table('quiz_options')
                    ->where('id', $optionId)
                    ->where('question_id', $questionId) // 🔥 relasi ke quiz_questions
                    ->first();

                $isCorrect = ($option && $option->is_correct == 1);

                if ($isCorrect) {
                    $benar++;
                } else {
                    $salah++;
                }

                $detail[] = [
                    'question_id' => $questionId,
                    'selected_option_id' => $optionId,
                    'is_correct' => $isCorrect,
                    'is_uncertain' => $result['is_uncertain'] ?? false,
                ];
            }

            return [
                'total' => $totalSoal,
                'benar' => $benar,
                'salah' => $salah,
                'nilai' => $totalSoal > 0
                    ? round(($benar / $totalSoal) * 100)
                    : 0,
                'detail' => $detail,
            ];
        });
    }
}

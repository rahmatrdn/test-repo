<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Presenter\Response;
use App\Usecase\Student\QuizUsecase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IntractiveQuiz extends Controller
{
    protected array $page = [
        'route' => 'interactive-quiz',
        'title' => 'Kuis'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected QuizUsecase $usecase,
    ) {
        $this->baseRedirect = 'student/' . $this->page['route'];
    }

    public function index(Request $request)
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'subject_id' => $request->get('subject_id'),
            'classroom' => $request->get('classroom'),
        ]);
        $data = $data['data']['list'] ?? [];

        //$subject = $this->subjectUsecase->getAll(['no_pagination' => true]);
        $subject = $subject['data']['list'] ?? [];

        return view('_student.quiz.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
            'subject_id' => $request->get('subject_id'),
            'subjects' => $subject,
            'classroom' => $request->get('classroom'),
        ]);
    }

    public function add(): View | Response
    {
        //$subjects = $this->subjectUsecase->getAll(['no_pagination' => true]);
        $subjects = $subjects['data']['list'] ?? [];

        return view('_teacher.learning_modules.add', [
            'page' => $this->page,
            'subjects' => $subjects,
        ]);
    }

    public function doCreate(Request $request)
    {
        $process = $this->usecase->create(
            data: $request,
        );

        if ($process['success']) {
            return redirect()
                ->route('teacher.learning_modules.index')
                ->with('success', 'Modul belajar berhasil ditambahkan.');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat menambahkan modul belajar.');
    }

    public function update(int $id)
    {
        //$subjects = $this->subjectUsecase->getAll(['no_pagination' => true]);
        $subjects = $subjects['data']['list'] ?? [];
        $data = $this->usecase->getByID($id);
        if (empty($data['data'])) {
            return redirect()->intended($this->baseRedirect)->with('error', 'Modul belajar tidak ditemukan.');
        }

        return view('_teacher.learning_modules.update', [
            'data' => $data['data']['data'] ?? [],
            'subjects' => $subjects,
            'page' => $this->page,
        ]);
    }

    public function doUpdate(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->update(id: $id, data: $request);

        if ($process['success']) {
            return redirect()
                ->route('teacher.learning_modules.index')
                ->with('success', 'Modul belajar berhasil diperbarui.');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat memperbarui modul belajar.');
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('teacher.learning_modules.index')
                ->with('success', 'Modul belajar berhasil dihapus.');
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat menghapus modul belajar.');
    }

    public function start(Request $request) {
        if($request->has('quiz_code')) {
            $quiz = $this->usecase->getByQuizCode($request->get('quiz_code'));
            if(!$quiz['success'] || empty($quiz['data'])) {
                return redirect()->back()->with('error', 'Kuis dengan kode tersebut tidak ditemukan.');
            }

            $time = $quiz['data']->quiz_time; // HH:MM:SS

            list($jam, $menit, $detik) = explode(":", $time);

            // total detik
            $totalDetik = ($jam * 3600) + ($menit * 60) + $detik;

            if ($totalDetik < 60) {
                $hasil = $totalDetik . " detik";
            } elseif ($totalDetik < 3600) {
                $hasil = ($totalDetik / 60) . " menit";
            } else {
                $hasil = ($totalDetik / 3600) . " jam";
            }

            return view('_student.quiz.start', [
                'quiz' => $quiz['data'],
                'time' => $hasil,
            ]);

        } else {
            return redirect()->back()->with('error', 'Kode kuis wajib diisi.');
        }
    }

    public function quizsoal(string $code) {
        $soal = $this->usecase->getQuizForSoalByQuizId($code);
        $quiz = $soal['data']['quiz'];

        $time = $quiz->quiz_time;
        [$jam, $menit, $detik] = array_map('intval', explode(':', $time));

        $totalDetik = ($jam * 3600) + ($menit * 60) + $detik;
        
        return view('_home.quiz.soal', [
            'quiz' => $quiz,
            'time' => $totalDetik,
            'soal' => $soal['data']['questions']
        ]);
    }

    public function hasilquiz(Request $request) {
        $time = $request->time;
        $quizId  = $request->quiz_id;
        $results = json_decode($request->results, true); // 🔥 penting

        if (!is_array($results)) {
            return redirect()->back()->with('error', 'Data jawaban tidak valid');
        }

        $time = (int) $request->time;

        $hasilTime = null;
        if ($time < 60) {
            $hasilTime = $time . ' detik';
        } else {
            $menit = floor($time / 60);
            $detik = $time % 60;

            $hasilTime = $detik > 0
                ? $menit . ' menit ' . $detik . ' detik'
                : $menit . ' menit';
        }

        $data = $this->usecase->checkQuizResult($quizId, $results);
        $quiz = $this->usecase->getQuizByQuizId($quizId);

        return view('_home.quiz.hasil', [
            'data' => $data,
            'quiz' => $quiz['data'],
            'time' => $hasilTime
        ]);
    }
}

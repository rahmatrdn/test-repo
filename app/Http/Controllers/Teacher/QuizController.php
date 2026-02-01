<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Usecase\Teacher\TeacherQuizUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected array $page = [
        'route' => 'quiz',
        'title' => 'Manajemen Kuis',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected TeacherQuizUsecase $usecase
    ) {
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request)
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
        ]);
        $data = $data['data']['list'] ?? [];

        return view('_teacher.quiz.index', [
            'page' => $this->page,
            'data' => $data,
            'keywords' => $request->get('keywords'),
        ]);
    }

    public function create(): View
    {
        return view('_teacher.quiz.add', [
            'page' => $this->page,
        ]);
    }

    public function store(Request $request)
    {
        $process = $this->usecase->create($request);

        if ($process['success']) {
            $quizCode = $process['data']['quiz_code'];

            return redirect()
                ->route('teacher.quiz.index')
                ->with('success', "Kuis berhasil dibuat dengan kode: {$quizCode}. Silakan tambahkan soal-soal.");
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat membuat kuis.');
    }

    public function addQuestions(int $id): View|RedirectResponse
    {
        $result = $this->usecase->getById($id);

        if (! $result['success']) {
            return redirect()
                ->route('teacher.quiz.index')
                ->with('error', 'Quiz tidak ditemukan');
        }

        return view('_teacher.quiz.add_questions', [
            'page' => $this->page,
            'quiz' => $result['data']['data'],
        ]);
    }

    public function storeQuestions(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->addQuestions($request, $id);

        if ($process['success']) {
            return redirect()
                ->route('teacher.quiz.questions.add', $id)
                ->with('success', 'Soal berhas berhasil ditambahkan');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat menambahkan soal.');
    }

    public function detail(int $id): View|RedirectResponse
    {
        $data = $this->usecase->getById($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', 'Kuis tidak ditemukan.');
        }

        return view('_teacher.quiz.detail', [
            'page' => $this->page,
            'data' => $data['data']['data'] ?? [],
        ]);
    }

    public function edit(int $id): View|RedirectResponse
    {
        $data = $this->usecase->getById($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', 'Kuis tidak ditemukan.');
        }

        return view('_teacher.quiz.edit', [
            'page' => $this->page,
            'data' => $data['data']['data'] ?? [],
        ]);
    }

    public function update(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->update($request, $id);

        if ($process['success']) {
            return redirect()
                ->route('teacher.quiz.index')
                ->with('success', 'Kuis berhasil diperbarui');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat memperbarui kuis.');
    }

    public function scores(int $id)
    {
        $result = $this->usecase->getById($id);

        if (!$result['success'] || empty($result['data'])) {
            return redirect()->intended($this->baseRedirect)->with('error', 'Kuis tidak ditemukan.');
        }

        $quizData = $result['data']['data'] ?? null;

        if (!$quizData) {
            return redirect()->intended($this->baseRedirect)->with('error', 'Data kuis tidak valid.');
        }

        $scoresResult = $this->usecase->getScoresByQuizId($id);
        
        $scores = $scoresResult['data']['list'] ?? null;

        return view('_teacher.quiz.scores', [
            'page'   => $this->page,
            'quiz'   => $quizData,
            'scores' => $scores,
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete($id);

        if ($process['success']) {
            return redirect()
                ->route('teacher.quiz.index')
                ->with('success', 'Kuis berhasil dihapus');
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? 'Terjadi kesalahan saat menghapus kuis.');
    }

    public function updateQuestion(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array',
            'correct_answer' => 'required|integer',
        ]);

        $process = $this->usecase->updateQuestion($id, $request->all());

        if ($process['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil diperbarui',
                'data' => $process['data'] ?? null,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $process['message'] ?? 'Terjadi kesalahan saat memperbarui soal',
        ], 400);
    }

    public function deleteQuestion(int $id): JsonResponse
    {
        $process = $this->usecase->deleteQuestion($id);

        if ($process['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $process['message'] ?? 'Terjadi kesalahan saat menghapus soal',
        ], 400);
    }
}

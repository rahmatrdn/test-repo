<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\Usecase\Teacher\TeacherQuizUsecase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class QuizGeneratorController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/quiz-generator',
        'title' => 'Alat AI - Pembuat Kuis'
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
            'type' => $request->get('type'),
        ]);

        $data = $data['data']['list'] ?? [];
        return view('_teacher.ai_tools.quiz.index', [
            'page' => $this->page,
            'data' => $data,
            'keywords' => $request->get('keywords'),
            'type' => $request->get('type'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('_teacher.ai_tools.quiz.add', [
            'page' => $this->page,
        ]);
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

    
    public function delete(int $id)
    {
        $result = $this->usecase->delete($id);

        if ($result['success']) {
            return redirect($this->baseRedirect)
                ->with('success', 'Data berhasil dihapus');
        }

        return redirect($this->baseRedirect)
            ->with('error', $result['message'] ?? 'Gagal menghapus data');
    }

    public function scores(int $id): View|RedirectResponse
    {
        $quiz = $this->usecase->getById($id);

        if (empty($quiz['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', 'Kuis tidak ditemukan.');
        }

        $scores = [];

        return view('_teacher.ai_tools.quiz.scrores', [
            'page' => $this->page,
            'quiz' => $quiz['data']['data'] ?? [],
            'scores' => $scores,
        ]);
    }
}

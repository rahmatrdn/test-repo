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
}

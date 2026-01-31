<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\Admin\ClassroomUsecase;
use App\Usecase\Admin\StudentUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class StudentController extends Controller
{
    protected array $page = [
        'route' => 'students',
        'title' => 'Akun Siswa',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected StudentUsecase $usecase,
        protected ClassroomUsecase $classroomUsecase
    ) {
        $this->baseRedirect = 'admin/' . $this->page['route'];
    }

    public function index(Request $request): View|Response
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'classroom_id' => $request->get('classroom_id'),
        ]);

        return view('_admin.students.index', [
            'data' => $data['data']['list'] ?? [],
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
            'classroom_id' => $request->get('classroom_id'),
            'classrooms' => $this->classroomUsecase->getAll(['no_pagination' => true])['data']['list'] ?? [],
        ]);
    }

    public function add(): View|Response
    {
        $classrooms = $this->classroomUsecase->getAll(['no_pagination' => true]);

        return view('_admin.students.add', [
            'page' => $this->page,
            'classrooms' => $classrooms['data']['list'] ?? [],
        ]);
    }

    public function doCreate(Request $request): RedirectResponse
    {
        $process = $this->usecase->create(data: $request);

        if ($process['success']) {
            return redirect()
                ->route('admin.students.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function update(int $id): View|RedirectResponse|Response
    {
        $student = $this->usecase->getById(id: $id);
        if (empty($student['data'])) {
            return redirect()->intended($this->baseRedirect)->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        $classrooms = $this->classroomUsecase->getAll(['no_pagination' => true]);

        return view('_admin.students.update', [
            'page' => $this->page,
            'data' => $student['data']['data'],
            'classrooms' => $classrooms['data']['list'] ?? [],
        ]);
    }

    public function doUpdate(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->update(id: $id, data: $request);

        if ($process['success']) {
            return redirect()
                ->route('admin.students.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('admin.students.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->route('admin.students.index')
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }


    public function doResetPassword(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->resetPassword(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('admin.students.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_RESET_PASSWORD);
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}

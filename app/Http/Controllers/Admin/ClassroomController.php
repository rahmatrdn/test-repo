<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\Admin\ClassroomUsecase;
use App\Usecase\Admin\StudentUsecase as AdminStudentUsecase;
use App\Usecase\StudentUsecase;
use App\Usecase\superAdmin\SchoolUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassroomController extends Controller
{
    protected array $page = [
        'route' => 'classrooms',
        'title' => 'Manajemen Kelas',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected ClassroomUsecase $usecase,
        protected SchoolUsecase $schoolUsecase
    ) {
        $this->baseRedirect = 'admin/' . $this->page['route'];
    }

    public function index(Request $request): View|Response
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
        ]);
        $data = $data['data']['list'] ?? [];


        return view('_admin.classrooms.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
        ]);
    }

    public function add(): View|Response
    {
        return view('_admin.classrooms.add', [
            'page' => $this->page,
        ]);
    }

    public function doCreate(Request $request): RedirectResponse
    {
        $process = $this->usecase->create(
            data: $request,
        );

        if ($process['success']) {
            return redirect()
                ->route('admin.classrooms.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function update(int $id): View|RedirectResponse|Response
    {
        $data = $this->usecase->getByID($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_admin.classrooms.update', [
            'data' => (object) $data['data'],
            'id' => $id,
            'page' => $this->page,
        ]);
    }

    public function doUpdate(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->update(
            data: $request,
            id: $id,
        );

        if ($process['success']) {
            return redirect()
                ->route('admin.classrooms.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
    public function detail(int $id): View|RedirectResponse|Response
    {
        $classroom = $this->usecase->getByID($id);

        if (empty($classroom['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        $studentUsecase = new AdminStudentUsecase();
        $studentsData = $studentUsecase->getAll([
            'classroom_id' => $id,
            'no_pagination' => true,
        ]);

        $students = $studentsData['data']['list'] ?? collect([]);

        return view('_admin.classrooms.detail', [
            'data' => (object) $classroom['data'],
            'students' => $students,
            'page' => $this->page,
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('admin.classrooms.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->route('admin.classrooms.index')
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}

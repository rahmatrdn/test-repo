<?php

namespace App\Http\Controllers\superAdmin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\superAdmin\SubjectUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubjectController extends Controller
{
    protected array $page = [
        'route' => 'subjects',
        'title' => 'Manajemen Mapel',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected SubjectUsecase $usecase
    ) {
        $this->baseRedirect = 'super_admin/'.$this->page['route'];
    }

    public function index(Request $request): View|Response
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
        ]);
        $data = $data['data']['list'] ?? [];

        return view('_super_admin.subjects.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
        ]);
    }

    public function add(): View|Response
    {
        return view('_super_admin.subjects.add', [
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
                ->route('superadmin.subjects.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        } else {   
            return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function update(int $id): View|RedirectResponse|Response
    {
        $data = $this->usecase->getByID($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_super_admin.subjects.update', [
            'data' => (object) $data['data'],
            'id' => $id,
            'page' => $this->page,
        ]);
    }

    public function doUpdate(int $id, Request $request)
    {
        $process = $this->usecase->update(
            data: $request,
            id: $id,
        );

        if ($process['success']) {
            return redirect()
                ->route('superadmin.subjects.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        } else {   
            return redirect()
                ->back()
                ->withInput()
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.subjects.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->route('superadmin.subjects.index')
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}
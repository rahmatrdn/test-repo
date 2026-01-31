<?php

namespace App\Http\Controllers\superAdmin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\superAdmin\SchoolUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SchoolController extends Controller
{
    protected array $page = [
        'route' => 'schools',
        'title' => 'Manajemen Sekolah',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected SchoolUsecase $usecase
    ) {
        $this->baseRedirect = 'superadmin/'.$this->page['route'];
    }

    public function index(Request $request): View|Response
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'status' => $request->get('status', 'all'),
        ]);
        $data = $data['data']['list'] ?? [];

        return view('_super_admin.schools.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
            'status' => $request->get('status', 'all'),
        ]);
    }

    public function update(int $id): View|RedirectResponse|Response
    {
        $data = $this->usecase->getByID($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_super_admin.schools.update', [
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
                ->route('superadmin.schools.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.schools.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED_SCHOOLS);
        }

        return redirect()
            ->route('superadmin.schools.index')
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function restore(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->restore(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.schools.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_RESTORED);
        }

        return redirect()
            ->route('superadmin.schools.index')
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}

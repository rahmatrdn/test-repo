<?php

namespace App\Http\Controllers\superAdmin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\UserUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected array $page = [
        'route' => 'superadmin.users',
        'title' => 'Pengguna Aplikasi',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected UserUsecase $usecase
    ) {
        $this->baseRedirect = 'superadmin/users';
    }

    public function index(Request $request): View|Response
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'access_type' => $request->get('access_type'),
            'school_id' => $request->get('school_id'),
        ]);
        $data = $data['data']['list'] ?? [];

        $schools = DB::table(DatabaseConst::SCHOOL)->whereNull('deleted_at')->get();

        return view('_super_admin.users.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
            'access_type' => $request->get('access_type'),
            'school_id' => $request->get('school_id'),
            'schools' => $schools,
        ]);
    }

    public function add(): View|Response
    {
        $schools = DB::table(DatabaseConst::SCHOOL)->whereNull('deleted_at')->get();

        return view('_super_admin.users.add', [
            'page' => $this->page,
            'schools' => $schools,
        ]);
    }

    public function doCreate(Request $request): RedirectResponse
    {
        $process = $this->usecase->create(
            data: $request,
        );

        if ($process['success']) {
            return redirect()
                ->route('superadmin.users.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function detail(int $id): View|RedirectResponse|Response
    {
        $data = $this->usecase->getByID($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
        $data = $data['data'] ?? [];

        return view('_super_admin.users.detail', [
            'data' => (object) $data,
            'page' => $this->page,
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
        $data = $data['data'] ?? [];

        $schools = DB::table(DatabaseConst::SCHOOL)->whereNull('deleted_at')->get();

        return view('_super_admin.users.update', [
            'data' => (object) $data,
            'userId' => $id,
            'page' => $this->page,
            'schools' => $schools,
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
                ->route('superadmin.users.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.users.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        } else {
            return redirect()
                ->route('superadmin.users.index')
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function resetPassword(int $id): RedirectResponse
    {
        $resetProcess = $this->usecase->resetPassword(id: $id);

        if ($resetProcess['success']) {
            return redirect()
                ->route('superadmin.users.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_RESET_PASSWORD);
        } else {
            return redirect()
                ->route('superadmin.users.index')
                ->with('error', $resetProcess['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }
}
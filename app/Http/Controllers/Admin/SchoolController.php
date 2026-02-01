<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\Admin\SchoolUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    protected array $page = [
        'route' => 'school',
        'title' => 'Registrasi Sekolah',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected SchoolUsecase $usecase
    ) {
        $this->baseRedirect = 'admin/'.$this->page['route'];
    }

    public function add(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user && $user->school_id) {
            return redirect()
                ->route('admin.dashboard')
                ->with('info', 'Anda sudah terdaftar di sekolah');
        }

        return view('_admin.schools.register', [
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
                ->route('admin.dashboard')
                ->with('success', 'Sekolah berhasil didaftarkan! Selamat datang.');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }
}

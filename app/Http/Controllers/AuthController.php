<?php

namespace App\Http\Controllers;

use App\Constants\DatabaseConst;
use App\Constants\UserConst;
use App\Usecase\UserUsecase;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private UserUsecase $userUsecase
    ) {
    }

    public function login()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('_admin.auth.login');
    }

    public function register()
    {
        return view('_admin.auth.register');
    }

    public function doRegister(Request $request)
    {
        $result = $this->userUsecase->register($request);

        if (!$result['success']) {
            return back()
                ->withErrors(['register_error' => $result['message']])
                ->withInput();
        }

        Auth::loginUsingId($result['data']['user_id']);

        return redirect()
            ->route('school.register')
            ->with('success', 'Akun berhasil dibuat! Silakan daftarkan sekolah Anda.');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->school_id) {
                $school = DB::table(DatabaseConst::SCHOOL)
                    ->where('id', $user->school_id)
                    ->first();

                if ($school && $school->deleted_at !== null) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'login_error' => 'Sekolah Anda sedang dinonaktifkan. Silakan hubungi admin.',
                    ])->onlyInput('email');
                }
            }

            $request->session()->regenerate();

            return $this->redirectByRole($user);
        }

        return back()->withErrors([
            'login_error' => 'Email atau Password tidak sesuai, periksa kembali',
        ])->onlyInput('email');
    }

    private function redirectByRole($user)
    {
        switch ($user->access_type) {
            case UserConst::SUPER_ADMIN:
                return redirect()->route('superadmin.dashboard');
            case UserConst::SUPER_ADMIN:
                return redirect()->intended(route('admin.dashboard'));
            case UserConst::GURU:
                return redirect()->route('teacher.dashboard');
            case UserConst::SISWA:
                return redirect()->intended(route('student.dashboard'));
            default:
                return redirect()->intended(route('admin.dashboard'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

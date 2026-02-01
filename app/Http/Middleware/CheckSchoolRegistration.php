<?php

namespace App\Http\Middleware;

use App\Constants\UserConst;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->access_type == UserConst::SUPER_ADMIN && is_null($user->school_id)) {
            $allowedRoutes = [
                'admin.dashboard',
                'school.register',
                'school.register.post',
                'logout',
            ];

            if (! in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('admin.dashboard')->with('error', 'Silakan daftarkan sekolah Anda terlebih dahulu untuk mengakses fitur ini.');
            }
        }

        return $next($request);
    }
}

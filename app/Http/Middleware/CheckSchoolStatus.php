<?php

namespace App\Http\Middleware;

use App\Constants\DatabaseConst;
use App\Constants\UserConst;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolStatus
{
    /**
     * Handle an incoming request.
     *
     * Check if user's school is still active (not soft deleted).
     * If school is deactivated, logout the user automatically.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Skip check if user is not authenticated
        if (! $user) {
            return $next($request);
        }

        // Skip check if user is SuperAdmin without school_id
        if ($user->access_type == UserConst::SUPER_ADMIN && is_null($user->school_id)) {
            return $next($request);
        }

        // If user has school_id, check if the school is still active
        if ($user->school_id) {
            $school = DB::table(DatabaseConst::SCHOOL)
                ->where('id', $user->school_id)
                ->first();

            // If school not found or has been soft deleted (deactivated)
            if (!$school || $school->deleted_at !== null) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->with('error', 'Sekolah Anda telah dinonaktifkan. Silakan hubungi administrator.');
            }
        }

        return $next($request);
    }
}

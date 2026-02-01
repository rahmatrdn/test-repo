<?php

namespace App\Usecase\Student;

use App\Constants\DatabaseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardUsecase extends Usecase
{
    public function getProfileData(): array
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return Response::buildErrorService();
            }

            $profile = DB::table(DatabaseConst::STUDENT . ' as s')
                ->join(DatabaseConst::USER . ' as u', 's.user_id', '=', 'u.id')
                ->join(DatabaseConst::CLASSROOM . ' as c', 's.classroom_id', '=', 'c.id')
                ->join(DatabaseConst::SCHOOL . ' as sch', 's.school_id', '=', 'sch.id')
                ->where('s.user_id', $user->id)
                ->whereNull('s.deleted_at')
                ->select(
                    'u.name',
                    'u.email',
                    'c.class_name',
                    'c.entry_year',
                    'sch.school_name',
                    'sch.address as school_address',
                    'sch.no_tlp as school_phone',
                    's.created_at as joined_at'
                )
                ->first();

            if (!$profile) {
                return Response::buildErrorNotFound('Data profil siswa tidak ditemukan');
            }

            // Calculate grade
            $grade = (now()->year - (int) $profile->entry_year) + 10;
            $profile->display_class = $grade . ' ' . $profile->class_name;

            return Response::buildSuccess([
                'profile' => $profile
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }
}

<?php

namespace App\Usecase\superAdmin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Constants\UserConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardUsecase extends Usecase
{
    public function __construct() {}

    public function getDashboardStats(): array
    {
        try {
            $totalSchools = DB::table(DatabaseConst::SCHOOL)
                ->whereNull('deleted_at')
                ->count();

            $totalTeachers = DB::table(DatabaseConst::TEACHER)
                ->whereNull('deleted_at')
                ->count();

            $totalStudents = DB::table(DatabaseConst::STUDENT)
                ->whereNull('deleted_at')
                ->count();

            $chartData = $this->getMonthlyRegistrationStats();

            return Response::buildSuccess(
                [
                    'total_schools' => $totalSchools,
                    'total_teachers' => $totalTeachers,
                    'total_students' => $totalStudents,
                    'chart_data' => $chartData,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getMonthlyRegistrationStats(): array
    {
        try {
            // Get data from current month only (daily stats)
            $now = Carbon::now();
            $currentYear = $now->year;
            $currentMonth = $now->month;
            $daysInMonth = $now->daysInMonth;

            $startOfMonth = Carbon::create($currentYear, $currentMonth, 1)->startOfDay();
            $endOfMonth = Carbon::create($currentYear, $currentMonth, $daysInMonth)->endOfDay();

            $registrations = DB::table(DatabaseConst::USER)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    'access_type',
                    DB::raw('COUNT(*) as count')
                )
                ->whereIn('access_type', [UserConst::ADMIN_SEKOLAH, UserConst::GURU, UserConst::SISWA])
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->whereNull('deleted_at')
                ->groupBy('date', 'access_type')
                ->orderBy('date')
                ->get();

            $categories = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($currentYear, $currentMonth, $day);
                $categories[] = $date->format('Y-m-d');
            }

            $seriesData = [
                UserConst::ADMIN_SEKOLAH => array_fill(0, $daysInMonth, 0),
                UserConst::GURU => array_fill(0, $daysInMonth, 0),
                UserConst::SISWA => array_fill(0, $daysInMonth, 0),
            ];

            // Fill in the actual data
            foreach ($registrations as $registration) {
                $dateIndex = array_search($registration->date, $categories);
                if ($dateIndex !== false && isset($seriesData[$registration->access_type])) {
                    $seriesData[$registration->access_type][$dateIndex] = $registration->count;
                }
            }

            // Format for ApexCharts
            $series = [
                [
                    'name' => 'Admin Sekolah',
                    'data' => array_values($seriesData[UserConst::ADMIN_SEKOLAH]),
                ],
                [
                    'name' => 'Guru',
                    'data' => array_values($seriesData[UserConst::GURU]),
                ],
                [
                    'name' => 'Siswa',
                    'data' => array_values($seriesData[UserConst::SISWA]),
                ],
            ];

            return [
                'categories' => $categories,
                'series' => $series,
            ];
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return [
                'categories' => [],
                'series' => [],
            ];
        }
    }
}

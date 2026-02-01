<?php

namespace App\Usecase\Admin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardUsecase extends Usecase
{
    public function __construct() {}

    public function getDashboardStats(): array
    {
        try {
            $schoolId = Auth::user()->school_id;

            if (! $schoolId) {
                throw new Exception('School ID not found for the authenticated user');
            }

            $totalTeachers = DB::table(DatabaseConst::TEACHER)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            $totalStudents = DB::table(DatabaseConst::STUDENT)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            $totalClassrooms = DB::table(DatabaseConst::CLASSROOM)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            // Count learning modules where school_id matches
            $totalLearningModules = DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            $chartData = $this->getMonthlyRegistrationStats($schoolId);

            return Response::buildSuccess(
                [
                    'total_teachers' => $totalTeachers,
                    'total_students' => $totalStudents,
                    'total_classrooms' => $totalClassrooms,
                    'total_learning_modules' => $totalLearningModules,
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

    public function getMonthlyRegistrationStats(int $schoolId): array
    {
        try {
            // Get data from current month only (daily stats)
            $now = Carbon::now();
            $currentYear = $now->year;
            $currentMonth = $now->month;
            $daysInMonth = $now->daysInMonth;

            $startOfMonth = Carbon::create($currentYear, $currentMonth, 1)->startOfDay();
            $endOfMonth = Carbon::create($currentYear, $currentMonth, $daysInMonth)->endOfDay();

            // Get teacher registrations by day
            $teacherRegistrations = DB::table(DatabaseConst::USER)
                ->join(DatabaseConst::TEACHER, DatabaseConst::USER.'.id', '=', DatabaseConst::TEACHER.'.user_id')
                ->select(
                    DB::raw('DATE('.DatabaseConst::USER.'.created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where(DatabaseConst::TEACHER.'.school_id', $schoolId)
                ->whereBetween(DatabaseConst::USER.'.created_at', [$startOfMonth, $endOfMonth])
                ->whereNull(DatabaseConst::USER.'.deleted_at')
                ->whereNull(DatabaseConst::TEACHER.'.deleted_at')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Get student registrations by day
            $studentRegistrations = DB::table(DatabaseConst::USER)
                ->join(DatabaseConst::STUDENT, DatabaseConst::USER.'.id', '=', DatabaseConst::STUDENT.'.user_id')
                ->select(
                    DB::raw('DATE('.DatabaseConst::USER.'.created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where(DatabaseConst::STUDENT.'.school_id', $schoolId)
                ->whereBetween(DatabaseConst::USER.'.created_at', [$startOfMonth, $endOfMonth])
                ->whereNull(DatabaseConst::USER.'.deleted_at')
                ->whereNull(DatabaseConst::STUDENT.'.deleted_at')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Create categories for all days in current month
            $categories = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($currentYear, $currentMonth, $day);
                $categories[] = $date->format('Y-m-d');
            }

            // Initialize data arrays with zeros
            $teacherData = array_fill(0, $daysInMonth, 0);
            $studentData = array_fill(0, $daysInMonth, 0);

            // Fill in the actual data
            foreach ($teacherRegistrations as $registration) {
                $dateIndex = array_search($registration->date, $categories);
                if ($dateIndex !== false) {
                    $teacherData[$dateIndex] = $registration->count;
                }
            }

            foreach ($studentRegistrations as $registration) {
                $dateIndex = array_search($registration->date, $categories);
                if ($dateIndex !== false) {
                    $studentData[$dateIndex] = $registration->count;
                }
            }

            // Format for ApexCharts
            $series = [
                [
                    'name' => 'Guru',
                    'data' => array_values($teacherData),
                ],
                [
                    'name' => 'Siswa',
                    'data' => array_values($studentData),
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

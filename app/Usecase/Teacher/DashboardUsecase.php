<?php

namespace App\Usecase\Teacher;

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
            $userId = Auth::user()->id;

            if (! $userId) {
                throw new Exception('User ID not found for the authenticated user');
            }

            $totalLearningModules = DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('created_by', $userId)
                ->whereNull('deleted_at')
                ->count();

            $totalDownloads = DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('created_by', $userId)
                ->whereNull('deleted_at')
                ->sum('total_download');

            $chartData = $this->getMonthlyDownloadStats($userId);

            return Response::buildSuccess(
                [
                    'total_learning_modules' => $totalLearningModules,
                    'total_downloads' => $totalDownloads,
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

    public function getMonthlyDownloadStats(int $userId): array
    {
        try {
            // Get data from current month only (daily stats)
            $now = Carbon::now();
            $currentYear = $now->year;
            $currentMonth = $now->month;
            $daysInMonth = $now->daysInMonth;

            $startOfMonth = Carbon::create($currentYear, $currentMonth, 1)->startOfDay();
            $endOfMonth = Carbon::create($currentYear, $currentMonth, $daysInMonth)->endOfDay();

            // Get download data by day
            // Note: This assumes downloads are tracked with timestamps
            // If you have a separate downloads tracking table, adjust accordingly
            $downloads = DB::table(DatabaseConst::LEARNING_MODULE)
                ->select(
                    DB::raw('DATE(updated_at) as date'),
                    DB::raw('SUM(total_download) as total')
                )
                ->where('created_by', $userId)
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->whereNull('deleted_at')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Create categories for all days in current month
            $categories = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($currentYear, $currentMonth, $day);
                $categories[] = $date->format('Y-m-d');
            }

            // Initialize data array with zeros
            $downloadData = array_fill(0, $daysInMonth, 0);

            // Fill in the actual data
            foreach ($downloads as $download) {
                $dateIndex = array_search($download->date, $categories);
                if ($dateIndex !== false) {
                    $downloadData[$dateIndex] = $download->total;
                }
            }

            // Format for ApexCharts
            $series = [
                [
                    'name' => 'Total Download',
                    'data' => array_values($downloadData),
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

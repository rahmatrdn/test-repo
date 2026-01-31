<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Usecase\Teacher\DashboardUsecase;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    protected array $page = [
        'route' => 'dashboard',
        'title' => 'Dashboard',
    ];

    public function __construct(
        protected DashboardUsecase $usecase
    ) {
    }

    public function index(): View
    {
        $data = $this->usecase->getDashboardStats();
        $stats = $data['data'] ?? [];

        $stats = array_merge([
            'total_learning_modules' => 0,
            'total_downloads' => 0,
        ], $stats);

        $chartData = $stats['chart_data'] ?? [
            'categories' => [],
            'series' => [],
        ];

        return view('_teacher.dashboard', [
            'stats' => $stats,
            'chartData' => $chartData,
            'page' => $this->page,
        ]);
    }
}

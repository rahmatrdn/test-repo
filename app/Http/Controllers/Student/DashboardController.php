<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Usecase\Student\DashboardUsecase;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardUsecase $usecase
    ) {}

    public function index(): View
    {
        $profileData = $this->usecase->getProfileData();

        return view('_student.dashboard', [
            'profile' => $profileData['data']['profile'] ?? null
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Usecase\LandingPageUsecase;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $landingPageUsecase = app(LandingPageUsecase::class);
        
        // Get sekolah counts by grade
        $gradeData = [];
        foreach (\App\Constants\GradeConst::getGrades() as $gradeId => $gradeName) {
            $result = $landingPageUsecase->getSekolahByGrades($gradeId);
            $gradeData[$gradeId] = [
                'name' => $gradeName,
                'count' => count($result['data']['list'] ?? [])
            ];
        }
        
        return view('_home.landing', compact('gradeData'));
    }

    public function kumpulan_materi($grade = null)
    {
        $landingPageUsecase = app(LandingPageUsecase::class);
        
        // Default ke SMP jika tidak ada grade
        $grade = $grade ?? \App\Constants\GradeConst::SMP;
        
        // Get subjects by grade
        $result = $landingPageUsecase->getSubjectsByGrade($grade);
        $subjects = $result['data']['list'] ?? [];
        
        return view('_home.kumpulan_materi', compact('subjects', 'grade'));
    }

    public function detail_materi()
    {
        return view('_home.detail_materi');
    }
}

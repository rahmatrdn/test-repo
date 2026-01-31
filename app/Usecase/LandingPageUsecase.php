<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Illuminate\Support\Facades\DB;

class LandingPageUsecase
{

    public function getSekolahByGrades($grade)
    {
        try {
            $sekolahs = DB::table(DatabaseConst::SCHOOL)
                ->where('grade', $grade)
                ->get();
            return Response::buildSuccess(
                [
                    'list' => $sekolahs,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (\Exception $e) {
            throw new \Exception('Error fetching schools by grade: ' . $e->getMessage());
        }
    }

    public function getSubjectsByGrade($grade)
    {
        try {
            $subjects = DB::table(DatabaseConst::SUBJECT)
                ->where('grade', $grade)
                ->whereNull('deleted_at')
                ->get();
            return Response::buildSuccess(
                [
                    'list' => $subjects,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (\Exception $e) {
            throw new \Exception('Error fetching subjects by grade: ' . $e->getMessage());
        }
    }

    public function execute()
    {
        //
    }
}

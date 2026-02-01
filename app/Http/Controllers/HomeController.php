<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usecase\QuizUsecase;
use Illuminate\Http\JsonResponse;
use App\Usecase\LandingPageUsecase;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private $useCase;
    private $quizUsecase;
    public function __construct(LandingPageUsecase $landingPageUsecase, QuizUsecase $quizUsecase) {
        $this->useCase = $landingPageUsecase;
        $this->quizUsecase = $quizUsecase;
    }

    public function index()
    {
        $mapel = $this->useCase->getAllSubject();
        return view('_home.landing', [
            'mapel' => $mapel['data']['list']
        ]);
    }

    public function get_materi(int $jenjang, int $kelas, string $mapel): JsonResponse
    {
        try {
            $subjectId = $mapel === 'semua' ? null : (int) $mapel;

            $materi = $this->useCase->getLearningModulFilter(
                $jenjang,
                $kelas,
                $subjectId
            );

            return response()->json([
                'status' => true,
                'data'   => $materi['data']['list'],
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function materi_download(string $id)
    {
        try {
            $result = $this->useCase->getLearningModulById($id);
            $modul  = $result['data']['detail'] ?? null;

            // ❌ Data tidak ditemukan
            if (! $modul) {
                return redirect()->back()->with('error', 'Materi tidak ditemukan');
            }

            $path = $modul->file_path; // learning_modules/1.pdf

            // ❌ File tidak ada
            if (! Storage::disk('public')->exists($path)) {
                return redirect()->back()->with('error', 'File materi tidak tersedia');
            }

            // ✅ Download file
            return Storage::disk('public')->download($path);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }

}

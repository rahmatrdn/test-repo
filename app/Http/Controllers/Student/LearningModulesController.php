<?php

namespace App\Http\Controllers\Student;

use App\Constants\DatabaseConst;
use App\Http\Controllers\Controller;
use App\Usecase\superAdmin\SubjectUsecase;
use App\Usecase\Teacher\LearningModulesUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LearningModulesController extends Controller
{
    protected array $page = [
        'route' => 'learning-modules',
        'title' => 'Modul Belajar'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected LearningModulesUsecase $usecase,
        protected SubjectUsecase $subjectUsecase
    ) {
        $this->baseRedirect = 'student/' . $this->page['route'];
    }

    public function index(Request $request): View
    {
        $subjects = $this->subjectUsecase->getAll(["no_pagination" => true]);
        $subjectsData = $subjects['data']['list'] ?? [];

        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'subject_id' => $request->get('subject_id'),
            'classroom' => $request->get('classroom'),
        ]);
        $data = $data['data']['list'] ?? [];

        return view('_student.learning_modules.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
            'subjects' => $subjectsData,
            'subject_id' => $request->get('subject_id'),
            'classroom' => $request->get('classroom'),
        ]);
    }

    public function download(Request $request, int $id)
    {
        $file = $this->usecase->getById($id);

        $data = $file['data']['data'] ?? null;

        if (! $data || ! $data->file_path) {
            abort(404);
        }

        DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->increment('total_download');

        return response()->download(
            storage_path('app/public/' . $data->file_path)
        );
    }
}

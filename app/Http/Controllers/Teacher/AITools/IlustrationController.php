<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Http\Presenter\Response as PresenterResponse;
use App\Jobs\RunImageGeneration;
use App\Usecase\superAdmin\PromptImageUsecase;
use App\Usecase\Teacher\IlustrationUsecase;
use App\Usecase\Teacher\ImageGenerationUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IlustrationController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/ilustrasi',
        'title' => 'Alat AI - Ilustrasi'
    ];

    protected string $baseRedirect;
    protected PromptImageUsecase $usecase;
    protected ImageGenerationUsecase $ilustrationUsecase;
    protected array $imageStyles = [
        1 => 'Realistic',
        2 => 'Digital Art',
        3 => 'Cartoon',
        4 => '3D Render',
        5 => 'Pixel Art',
    ];
    protected IlustrationUsecase $historyIlustrationUsecase;

    public function __construct(PromptImageUsecase $usecase, ImageGenerationUsecase $ilustrationUsecase, IlustrationUsecase $historyIlustrationUsecase)
    {
        $this->usecase = $usecase;
        $this->ilustrationUsecase = $ilustrationUsecase;
        $this->historyIlustrationUsecase = $historyIlustrationUsecase;
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index()
    {
        $promptImages = $this->usecase->getAll(['no_pagination' => true]);
        $history = $this->historyIlustrationUsecase->getAll([
            'image_style_id' => request()->get('image_style_id'),
            'keywords' => request()->get('keywords'),
        ]);
        // return $promptImages['data']['list'] ?? [];
        return view('_teacher.ai_tools.ilustrasi.index', [
            'page' => $this->page,
            'image_style_id' => request()->get('image_style_id'),
            'promptImages' => $promptImages['data']['list'] ?? [],
            'data' => $history['data']['list'] ?? [],
        ]);
    }

    public function create(): View
    {
        $data = $this->usecase->getAll();

        return view('_teacher.ai_tools.ilustrasi.add', [
            'data' => $data['data']['list'] ?? [],
            'page' => $this->page,
        ]);
    }

    public function detail(int $id): View | RedirectResponse | Response
    {
        $data = $this->historyIlustrationUsecase->getByID($id);

        if (empty($data['data'])) {
            return redirect()
                ->route('teacher.ai.ilustrasi.index')
                ->with('error', 'Data tidak ditemukan');
        }

        return view('_teacher.ai_tools.ilustrasi.detail', [
            'data' => $data['data']['data'] ?? [],
            'page' => $this->page,
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->historyIlustrationUsecase->delete($id);

        if ($process['success']) {
            return redirect()
                ->route('teacher.ai.ilustrasi.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}

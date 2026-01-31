<?php

namespace App\Http\Controllers\superAdmin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\superAdmin\PromptImageUsecase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PromptImageController extends Controller
{
    protected array $page = [
        'route' => 'image-prompts',
        'title' => 'Gaya Gambar',
    ];

    protected string $baseRedirect;
    public function __construct(
        protected PromptImageUsecase $usecase
    ) {
        $this->baseRedirect = 'admin/' . $this->page['route'];
    }

    public function index(Request $request): Response | View
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
        ]);

        return view('_super_admin.prompt_image.index', [
            'data' => $data['data']['list'] ?? [],
            'keywords' => $request->get('keywords'),
            'page' => $this->page
        ]);
    }

    public function add(): Response | View
    {
        return view('_super_admin.prompt_image.add', [
            'page' => $this->page
        ]);
    }

    public function doCreate(Request $request): RedirectResponse
    {
        $process = $this->usecase->create($request);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.image-prompts.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function edit(int $id): View | RedirectResponse | Response
    {
        $data = $this->usecase->getByID($id);

        if (empty($data['data'])) {
            return redirect()
                ->intended($this->baseRedirect)
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
        $data = $data['data'] ?? [];

        return view('_super_admin.prompt_image.update', [
            'data' => (object) $data,
            'id' => $id,
            'page' => $this->page,
        ]);
    }

    public function doUpdate(Request $request, int $id)
    {
        $process = $this->usecase->update($request, $id);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.image-prompts.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete($id);

        if ($process['success']) {
            return redirect()
                ->route('superadmin.image-prompts.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}

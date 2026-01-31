<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\Usecase\Teacher\AiMateriAjarUsecase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MateriAjarController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/materi-ajar',
        'title' => 'Alat AI - Materi Ajar'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected AiMateriAjarUsecase $usecase
    )
    {
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request)
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'type' => $request->get('type'),
        ]);

        $data = $data['data']['list'] ?? [];
        return view('_teacher.ai_tools.materi.index', [
            'page' => $this->page,
            'data' => $data,
            'keywords' => $request->get('keywords'),
            'type' => $request->get('type'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('_teacher.ai_tools.materi.add', [
            'page' => $this->page,
        ]);
    }

    public function detail(int $id)
    {
        $result = $this->usecase->getById($id);

        if (!$result['success']) {
            return redirect($this->baseRedirect)
                ->with('error', $result['message'] ?? 'Data tidak ditemukan');
        }

        // return $result['data'] ?? [];

        return view('_teacher.ai_tools.materi.detail', [
            'page' => $this->page,
            'data' => $result['data']['data'] ?? [],
        ]);
    }

    public function delete(int $id)
    {
        $result = $this->usecase->delete($id);

        if ($result['success']) {
            return redirect($this->baseRedirect)
                ->with('success', 'Data berhasil dihapus');
        }

        return redirect($this->baseRedirect)
            ->with('error', $result['message'] ?? 'Gagal menghapus data');
    }
}

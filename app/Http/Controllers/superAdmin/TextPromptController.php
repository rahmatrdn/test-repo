<?php

namespace App\Http\Controllers\superAdmin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\TextPromptUsecase;
use Illuminate\Http\Request;

class TextPromptController extends Controller
{
    public function __construct(
        protected TextPromptUsecase $usecase
    ) {}
    public function add()
    {
        //Tambahkan Views untuk menampilkan form penambahan prompt (Internal Access)
    }

    public function doCreate(Request $request)
    {
        $process = $this->usecase->create($request);
        if ($process['success']) {
            return redirect()
                ->route('')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function edit()
    {
        // Tambahkan Views untuk menampilkan form pengeditan prompt (Internal Access)
    }

    public function doUpdate(Request $request, $id)
    {
        $process = $this->usecase->update($request, $id);
        if ($process['success']) {
            return redirect()
                ->route('')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }

    public function delete($id)
    {
        $process = $this->usecase->delete($id);
        if ($process['success']) {
            return redirect()
                ->route('')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        } else {
            return redirect()
                ->back()
                ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
        }
    }
}

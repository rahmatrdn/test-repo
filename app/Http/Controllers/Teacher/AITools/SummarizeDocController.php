<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\Http\Presenter\Response;
use App\Jobs\RunDocSummarizer;
use App\UseCases\Teacher\SummarizeDocUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummarizeDocController extends Controller
{
    /**
     * Synchronous summarization using Gemini File API
     */
    public function summarize(Request $request, SummarizeDocUsecase $summarizeUsecase)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,webp,png,jpg,jpeg|max:20480',
        ]);

        try {
            $result = $summarizeUsecase->summarize(
                $request->file('document'),
            );

            return Response::buildSuccess(
                data: $result,
                message: 'Document summarized successfully'
            );
        } catch (\Exception $e) {
            return Response::buildErrorService(
                message: $e->getMessage()
            );
        }
    }

    public function summarizeAsync(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            $file = $request->file('document');

            // Store file temporarily
            $storedPath = $file->store('temp-documents');

            // Dispatch job
            RunDocSummarizer::dispatch(
                $storedPath,
                $file->getClientOriginalName(),
                $file->getMimeType(),
                $request->input('prompt'),
                Auth::user()?->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Document is being processed. You will be notified when completed.',
                'job_id' => basename($storedPath)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

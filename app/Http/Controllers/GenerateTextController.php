<?php

namespace App\Http\Controllers;

use App\Jobs\RunTextGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateTextController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'level' => 'required|string|in:SD,SMP,SMA',
        ]);

        $referenceId = Str::uuid()->toString();

        $message = 'Buatkan materi "' . htmlspecialchars($request->topic, ENT_QUOTES)
                   . '" untuk tingkat ' . htmlspecialchars($request->level, ENT_QUOTES);

        RunTextGeneration::dispatch(
            message: $message,
            topic: $request->topic,
            level: $request->level,
            referenceId: $referenceId
        );

        return response()->json([
            'success' => true,
            'message' => 'Text generation job queued successfully',
            'reference_id' => $referenceId,
            'status_url' => route('generate_text_status', ['referenceId' => $referenceId]),
        ], 202);
    }

    public function status(string $referenceId)
    {
        $filePath = "generated-texts/{$referenceId}.txt";

        if (Storage::disk('local')->exists($filePath)) {
            $content = Storage::disk('local')->get($filePath);

            return response()->json([
                'success' => true,
                'status' => 'completed',
                'reference_id' => $referenceId,
                'content' => $content,
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'processing',
            'reference_id' => $referenceId,
            'message' => 'Text generation is still in progress',
        ], 202);
    }
}

<?php

namespace App\Usecase\SuperAdmin;

use App\Constants\AIConst;
use App\Constants\DatabaseConst;
use App\Http\Presenter\Response;
use App\Usecase\superAdmin\ToolsAiUsecase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TextGenerationUsecase
{
    private ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }

    /**
     * Add text generation history record
     */
    public function addHistory(array $data, string $completedPath): void
    {
        DB::table(DatabaseConst::TEXT_GENERATION_HISTORY)->insert([
            'user_input' => $data['input'],
            'output_text' => $data['content'],
            'output_file_path' => $completedPath,
            'type' => $data['categories'] === "PPT" ? 0 : 1,
            'token_usage' => $data['usage']['total_tokens'] ?? 0,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()?->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Text generation history saved successfully', [
            'user_id' => Auth::user()->id,
            'file_path' => $completedPath,
        ]);
    }

    //Gemini Model Text Generation
    public function generateTextGemini(string $description, string $categories): array
    {
        $templatePrompt = DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
            ->where('categories', $categories)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->first();

        if (!$templatePrompt) {
            return Response::buildErrorNotFound(
                'Invalid text generation categories provided.'
            );
        }

        $prompt = $this->aiToolsUsecase->resolver(
            $templatePrompt->text_prompt,
            [
                'description' => $description,
                'categories'  => $categories
            ]
        );

        $apiKey = $this->aiToolsUsecase->getApikeys('gemini');
        $url = AIConst::getUrlTextGeneration(
            AIConst::GEMINI_TEXT_MODEL,
            $apiKey
        );

        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.7,
                "responseMimeType" => "application/json",
                "maxOutputTokens" => 4096,
            ]
        ];

        $data = $this->aiToolsUsecase->makeRequest($url, $payload);

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            return Response::buildErrorService(
                'Failed to generate text from AI.'
            );
        }

        $usage = $data['usageMetadata'] ?? [];

        return Response::buildSuccess([
            'input' => $description,
            'categories' => $categories,
            'content'    => $text,
            'usage'      => [
                'prompt_tokens'     => $usage['promptTokenCount'] ?? 0,
                'completion_tokens' => $usage['candidatesTokenCount'] ?? 0,
                'total_tokens'      => $usage['totalTokenCount'] ?? 0,
            ]
        ], 200, 'Text generated successfully');
    }

    //Model Gemini geneerate quiz
    public function generateQuizGemini(
        string $topic,
        int $total_question,
        string $education_level,
        string $grade,
        int $option_count,
        string $categories
    ): array {
        $templatePrompt = DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
            ->where('categories', $categories)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->first();

        if (!$templatePrompt) {
            return Response::buildErrorNotFound(
                'Invalid text generation categories provided.'
            );
        }

        $prompt = $this->aiToolsUsecase->resolver(
            $templatePrompt->text_prompt,
            [
                'topic' => $topic,
                'total_questions' => $total_question,
                'education_level' => $education_level,
                'class'  => $grade,
                'options_count'  => $option_count
            ]
        );


        $apiKey = $this->aiToolsUsecase->getApikeys('gemini');
        $url = AIConst::getUrlTextGeneration(
            AIConst::GEMINI_TEXT_MODEL,
            $apiKey
        );

        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.7,
                "responseMimeType" => "application/json",
            ]
        ];

        $data = $this->aiToolsUsecase->makeRequest($url, $payload);

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            return Response::buildErrorService(
                'Failed to generate text from AI.'
            );
        }

        $usage = $data['usageMetadata'] ?? [];

        return Response::buildSuccess([
            'input' => $prompt,
            'categories' => $categories,
            'content'    => $text,
            'usage'      => [
                'prompt_tokens'     => $usage['promptTokenCount'] ?? 0,
                'completion_tokens' => $usage['candidatesTokenCount'] ?? 0,
                'total_tokens'      => $usage['totalTokenCount'] ?? 0,
            ]
        ], 200, 'Text generated successfully');
    }
}

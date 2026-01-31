<?php

namespace App\Usecase\superAdmin;

use App\Constants\AIConst;
use Illuminate\Support\Facades\Http;

class ToolsAiUsecase
{
    public function getApikeys(string $model): string
    {
        $key = config("services.api_keys.$model");

        if (!$key) {
            throw new \RuntimeException("API key for model [$model] is not configured.");
        }

        return $key;
    }

    public static function resolver(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }
        return $template;
    }

    public function makeRequest(
        string $url,
        array $payload,
        bool $isBearerAuth = false,
        string $modelName = ''
    ): array {
        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'SmartSekolah-App/1.0 (Laravel)',
        ];

        if ($isBearerAuth) {
            $headers['Authorization'] = 'Bearer ' . $this->getApikeys($modelName);
        }

        $client = Http::withOptions(AIConst::getTimeoutSettings())
            ->withHeaders($headers);

        $response = $client->post($url, $payload);
        // dd($response);

        $response->throw();

        return $response->json() ?? [];
    }

    public function extractImageFromResponse(array $data): array
    {
        $parts = $data['candidates'][0]['content']['parts'] ?? [];

        foreach ($parts as $part) {
            if (isset($part['inlineData'])) {
                return [
                    'data' => $part['inlineData']['data'],
                    'mimeType' => $part['inlineData']['mimeType']
                ];
            }
        }

        throw new \Exception('Image not found in Gemini response');
    }
}

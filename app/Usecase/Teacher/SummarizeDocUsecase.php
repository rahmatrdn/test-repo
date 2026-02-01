<?php

namespace App\Usecase\Teacher;

use App\Usecase\superAdmin\ToolsAiUsecase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SummarizeDocUsecase
{
    protected ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }

    /**
     * Summarize uploaded document with optional user prompt
     *
     * @param UploadedFile $file
     * @param string|null $userPrompt
     * @return array
     */
    public function summarize(UploadedFile $file, ?string $userPrompt = null): array
    {
        $this->validateFile($file);

        $apiKey = $this->aiToolsUsecase->getApikeys('gemini');

        if (empty($apiKey)) {
            throw new \RuntimeException('Gemini API key not found');
        }

        // Upload file to Gemini File API
        $uploadedFileData = $this->uploadFileToGemini($file, $apiKey);

        // Wait for file processing
        $this->waitForFileProcessing($uploadedFileData['name'], $apiKey);

        // Generate summary using the uploaded file
        $summary = $this->generateSummary($uploadedFileData['uri'], $file->getMimeType(), $apiKey);

        // Delete file from Gemini after processing
        $this->deleteFileFromGemini($uploadedFileData['name'], $apiKey);

        return [
            'success' => true,
            'summary' => $summary,
            'file_type' => $file->getClientOriginalExtension(),
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize()
        ];
    }

    /**
     * Validate uploaded file
     */
    protected function validateFile(UploadedFile $file): void
    {
        $allowedExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'webp', 'png', 'jpg', 'jpeg'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            throw new \RuntimeException('File type not supported. Only PDF, DOC, DOCX, PPT, PPTX, WEBP, PNG, JPG, and JPEG are allowed.');
        }

        if ($file->getSize() > 20 * 1024 * 1024) {
            throw new \RuntimeException('File size exceeds 20MB limit.');
        }
    }

    /**
     * Upload file to Gemini File API using resumable upload
     *
     * @param UploadedFile $file
     * @param string $apiKey
     * @return array
     */
    protected function uploadFileToGemini(UploadedFile $file, string $apiKey): array
    {
        try {
            $mimeType = $file->getMimeType();
            $numBytes = $file->getSize();
            $displayName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Step 1: Initial resumable request to get upload URL
            $initialResponse = Http::withHeaders([
                'X-Goog-Upload-Protocol' => 'resumable',
                'X-Goog-Upload-Command' => 'start',
                'X-Goog-Upload-Header-Content-Length' => $numBytes,
                'X-Goog-Upload-Header-Content-Type' => $mimeType,
                'Content-Type' => 'application/json',
            ])->post(
                "https://generativelanguage.googleapis.com/upload/v1beta/files?key={$apiKey}",
                [
                    'file' => [
                        'display_name' => $displayName
                    ]
                ]
            );

            if (!$initialResponse->successful()) {
                throw new \RuntimeException('Failed to initiate file upload: ' . $initialResponse->body());
            }

            // Get upload URL from response headers
            $uploadUrl = $initialResponse->header('X-Goog-Upload-URL');

            if (empty($uploadUrl)) {
                throw new \RuntimeException('Upload URL not found in response headers');
            }

            // Step 2: Upload the actual file content
            $uploadResponse = Http::withHeaders([
                'Content-Length' => $numBytes,
                'X-Goog-Upload-Offset' => '0',
                'X-Goog-Upload-Command' => 'upload, finalize',
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $mimeType
            )->post($uploadUrl);

            if (!$uploadResponse->successful()) {
                throw new \RuntimeException('Failed to upload file: ' . $uploadResponse->body());
            }

            $fileInfo = $uploadResponse->json();

            Log::info('File uploaded to Gemini', [
                'file_name' => $file->getClientOriginalName(),
                'file_uri' => $fileInfo['file']['uri'] ?? null
            ]);

            return [
                'uri' => $fileInfo['file']['uri'],
                'name' => $fileInfo['file']['name'],
                'display_name' => $fileInfo['file']['displayName'],
                'mime_type' => $fileInfo['file']['mimeType']
            ];
        } catch (\Exception $e) {
            throw new \RuntimeException('Error uploading file to Gemini: ' . $e->getMessage());
        }
    }

    /**
     * Wait for file processing to complete
     *
     * @param string $fileName
     * @param string $apiKey
     * @return void
     */
    protected function waitForFileProcessing(string $fileName, string $apiKey): void
    {
        $maxAttempts = 30;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $response = Http::get(
                "https://generativelanguage.googleapis.com/v1beta/{$fileName}?key={$apiKey}"
            );

            if (!$response->successful()) {
                throw new \RuntimeException('Failed to check file status: ' . $response->body());
            }

            $fileData = $response->json();
            $state = $fileData['state'] ?? 'UNKNOWN';

            if ($state === 'ACTIVE') {
                Log::info('File processing completed', ['file_name' => $fileName]);
                return;
            }

            if ($state === 'FAILED') {
                throw new \RuntimeException('File processing failed');
            }

            // Wait 2 seconds before checking again
            sleep(2);
            $attempt++;
        }

        throw new \RuntimeException('File processing timeout');
    }

    /**
     * Generate summary using Gemini API with uploaded file
     *
     * @param string $fileUri
     * @param string $mimeType
     * @param string|null $userPrompt
     * @param string $apiKey
     * @return string
     */
    protected function generateSummary(string $fileUri, string $mimeType, string $apiKey): string
    {
        try {

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'file_data' => [
                                    'mime_type' => $mimeType,
                                    'file_uri' => $fileUri
                                ]
                            ],
                            [
                                'text' => 'Berikan ringkasan dokumen ini dalam Bahasa Indonesia. Langsung berikan isi ringkasan tanpa kalimat pembuka atau pengantar apapun (seperti Berikut adalah...). Gunakan struktur Markdown berikut:
(Isi ringkasan dalam 1-2 paragraf)
Poin-Poin Kunci
(Gunakan bullet points untuk ide utama/data penting)
Insight/Kesimpulan (Isi kesimpulan akhir)
Pastikan bahasa profesional dan langsung fokus pada konten.'
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 1.2,
                    'maxOutputTokens' => 2048,
                ]
            ];

            $response = Http::timeout(120)
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                    $payload
                );

            if (!$response->successful()) {
                throw new \RuntimeException('Gemini API request failed: ' . $response->body());
            }

            $result = $response->json();

            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            }

            throw new \RuntimeException('Invalid response format from Gemini API');
        } catch (\Exception $e) {
            throw new \RuntimeException('Error generating summary: ' . $e->getMessage());
        }
    }

    /**
     * Delete file from Gemini File API
     *
     * @param string $fileName
     * @param string $apiKey
     * @return void
     */
    protected function deleteFileFromGemini(string $fileName, string $apiKey): void
    {
        try {
            $response = Http::delete(
                "https://generativelanguage.googleapis.com/v1beta/{$fileName}?key={$apiKey}"
            );

            if ($response->successful()) {
                Log::info('File deleted from Gemini', ['file_name' => $fileName]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete file from Gemini', [
                'file_name' => $fileName,
                'error' => $e->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Tools;

use App\Usecase\GeminiUsecase as UsecaseGeminiUsecase;
use Vizra\VizraADK\Contracts\ToolInterface;
use Vizra\VizraADK\Memory\AgentMemory;
use Vizra\VizraADK\System\AgentContext;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiTools implements ToolInterface
{
    /**
     * Get the tool's definition for the LLM.
     * This structure should be JSON schema compatible.
     */
    public function definition(): array
    {
        Log::debug('🎯 GeminiTools: definition() called');

        return [
            'name' => 'generate_educational_text',
            'description' => 'Generate educational text content using Gemini AI. Use this tool when you need to create structured learning materials for various education levels.',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'topic' => [
                        'type' => 'string',
                        'description' => 'The educational topic to explain (e.g., "Photosynthesis", "Pythagorean Theorem", "Indonesian History")',
                        'minLength' => 3,
                        'maxLength' => 200,
                    ],
                    'level' => [
                        'type' => 'string',
                        'description' => 'Target education level for the content',
                        'enum' => ['SD', 'SMP', 'SMA'],
                    ],
                ],
                'required' => ['topic', 'level'],
            ],
        ];
    }

    /**
     * Execute the tool's logic.
     *
     * @param array $arguments
     * @param AgentContext $context
     * @param AgentMemory $memory
     * @return string JSON string result
     */
    public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    {
        Log::debug('🚀 GeminiTools: execute() called', [
            'arguments_received' => $arguments,
            'arguments_keys' => array_keys($arguments),
            'context_class' => get_class($context),
            'memory_class' => get_class($memory),
            'timestamp' => now()->toISOString(),
            'memory_usage' => memory_get_usage() / 1024 / 1024 . ' MB'
        ]);

        try {
            // Debug input sanitization
            $topic = trim($arguments['topic'] ?? '');
            $level = strtoupper(trim($arguments['level'] ?? ''));

            Log::debug('📝 GeminiTools: Sanitized input', [
                'raw_topic' => $arguments['topic'] ?? 'null',
                'sanitized_topic' => $topic,
                'raw_level' => $arguments['level'] ?? 'null',
                'sanitized_level' => $level,
                'is_topic_empty' => empty($topic),
                'is_level_empty' => empty($level)
            ]);

            // Validation
            if (empty($topic)) {
                Log::warning('❌ GeminiTools: Empty topic detected');
                return $this->errorResponse('Topic cannot be empty');
            }

            if (empty($level)) {
                Log::warning('❌ GeminiTools: Empty level detected');
                return $this->errorResponse('Level cannot be empty');
            }

            $validLevels = ['SD', 'SMP', 'SMA'];
            if (!in_array($level, $validLevels)) {
                Log::warning('❌ GeminiTools: Invalid level', [
                    'received_level' => $level,
                    'valid_levels' => $validLevels
                ]);
                return $this->errorResponse(
                    "Invalid level. Must be one of: " . implode(', ', $validLevels)
                );
            }

            Log::debug('✅ GeminiTools: Input validation passed', [
                'topic' => $topic,
                'level' => $level
            ]);

            // Call GeminiUsecase
            Log::debug('📞 GeminiTools: Calling GeminiUsecase::generateText()', [
                'usecase_class' => UsecaseGeminiUsecase::class,
                'calling_method' => 'generateText'
            ]);

            $startTime = microtime(true);
            $text = app(UsecaseGeminiUsecase::class)->generateText($topic, $level);
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);

            Log::debug('📥 GeminiTools: GeminiUsecase response received', [
                'execution_time_ms' => $executionTime,
                'has_response' => !empty($text),
                'response_length' => strlen($text ?? ''),
                'response_preview' => substr($text ?? '', 0, 100) . (strlen($text ?? '') > 100 ? '...' : ''),
                'is_string' => is_string($text)
            ]);

            if (empty($text)) {
                Log::error('❌ GeminiTools: Empty response from GeminiUsecase');
                return $this->errorResponse('Failed to generate content. Empty response from AI.');
            }

            $result = [
                'topic' => $topic,
                'level' => $level,
                'content' => $text,
                'word_count' => str_word_count($text),
                'generated_at' => now()->toISOString(),
                'execution_time_ms' => $executionTime,
                'tool_name' => 'generate_educational_text'
            ];

            Log::info('✅ GeminiTools: Successfully generated content', [
                'topic' => $topic,
                'level' => $level,
                'word_count' => $result['word_count'],
                'execution_time' => $executionTime . 'ms'
            ]);

            return $this->successResponse($result);

        } catch (Exception $e) {
            Log::error('🔥 GeminiTools: Exception occurred', [
                'topic' => $arguments['topic'] ?? 'unknown',
                'level' => $arguments['level'] ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'arguments_dump' => json_encode($arguments),
                'timestamp' => now()->toISOString()
            ]);

            return $this->errorResponse(
                'An error occurred while generating content: ' . $e->getMessage()
            );
        } finally {
            Log::debug('🏁 GeminiTools: execute() completed', [
                'peak_memory' => memory_get_peak_usage() / 1024 / 1024 . ' MB',
                'total_time' => round((microtime(true) - LARAVEL_START) * 1000, 2) . 'ms'
            ]);
        }
    }

    /**
     * Helper: Success response format
     */
    private function successResponse(array $data): string
    {
        Log::debug('📤 GeminiTools: Sending success response', [
            'response_keys' => array_keys($data),
            'content_length' => strlen($data['content'] ?? '')
        ]);

        return json_encode([
            'status' => 'success',
            'data' => $data,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Helper: Error response format
     */
    private function errorResponse(string $message): string
    {
        Log::debug('📤 GeminiTools: Sending error response', [
            'error_message' => $message
        ]);

        return json_encode([
            'status' => 'error',
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

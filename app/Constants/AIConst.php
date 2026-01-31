<?php

namespace App\Constants;

class AIConst
{
    const TIMEOUT = 120;
    const CONNECT_TIMEOUT = 60;

    // Models
    const IMAGE_MODEL = 'gemini-2.5-flash-image';
    const GEMINI_TEXT_MODEL = 'gemini-3-flash-preview';
    const OPENAI_TEXT_MODEL = 'gpt-4o-mini';
    const DEEPSEEK_TEXT_MODEL = 'deepseek-chat';

    const GEMINI_BASE_URL = 'https://generativelanguage.googleapis.com/v1beta/models/';
    // const IMAGE_API_URL = 'https://api.generativeai.google.com/v1/images:generate';
    const OPENAI_API_URL = 'https://api.openai.com/v1/responses';
    const DEEPSEEK_API_URL = 'https://api.deepseek.com/v1/chat/completions';

    public static function getUrlTextGeneration(string $model, string $apiKey): string
    {
        return match ($model) {
            self::GEMINI_TEXT_MODEL => self::GEMINI_BASE_URL . self::GEMINI_TEXT_MODEL . ":generateContent?key={$apiKey}",
            self::OPENAI_TEXT_MODEL => self::OPENAI_API_URL,
            self::DEEPSEEK_TEXT_MODEL => self::DEEPSEEK_API_URL,
            default => throw new \InvalidArgumentException("Invalid model: {$model}"),
        };
    }

    public static function getUrlImageGeneration(string $model, string $apiKey): string
    {
        return match ($model) {
            self::IMAGE_MODEL => self::GEMINI_BASE_URL . self::IMAGE_MODEL . ":generateContent?key={$apiKey}",
            default => throw new \InvalidArgumentException("Invalid model: {$model}"),
        };
    }

    public static function getTimeoutSettings(): array
    {
        return [
            'timeout' => self::TIMEOUT,
            'connect_timeout' => self::CONNECT_TIMEOUT,
        ];
    }

}

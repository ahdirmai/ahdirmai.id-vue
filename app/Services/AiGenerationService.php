<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;

class AiGenerationService
{
    /**
     * Generate content using Gemini AI strictly in JSON format.
     *
     * @param string $prompt The prompt instructing what to generate.
     * @return array|null Returns the decoded JSON array, or null on failure.
     * @throws \Exception
     */
    public function generateJson(string $prompt): ?array
    {
        // Use gemini-2.5-flash specifically
        $result = Gemini::generativeModel('models/gemini-2.5-flash')->generateContent($prompt);
        $text = $result->text();
        
        // Cleanup potential markdown blocks if Gemini ignores the instruction
        $text = str_replace(['```json', '```'], '', $text);
        
        return json_decode(trim($text), true);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
    }

    public function generateRecipe(array $ingredients)
    {
        // التحقق من وجود مكونات لتجنب طلبات فارغة
        if (empty($ingredients)) {
            return ['error' => 'No ingredients provided'];
        }

        $ingredientsString = implode(', ', $ingredients);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl, [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a professional chef. You MUST respond ONLY with a valid JSON object. Do not include any introductory text or markdown code blocks. 
                        The structure must be exactly: 
                        {
                            \"name\": \"Recipe Name\",
                            \"description\": \"Brief description\",
                            \"preparation_steps\": \"Step 1... Step 2...\",
                            \"cook_time\": 30
                        }"
                    ],
                    [
                        'role' => 'user',
                        'content' => "Suggest a recipe using these ingredients: " . $ingredientsString
                    ]
                ],
                'temperature' => 0.6,
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '{}';
                
                // تنظيف النص في حال أضاف الـ AI علامات ```json
                $cleanContent = preg_replace('/```json|```/', '', $content);
                
                return json_decode(trim($cleanContent), true) ?? ['error' => 'Failed to parse AI response'];
            }

            Log::error('Groq API Error: ' . $response->body());
            return ['error' => 'API Connection Failed', 'details' => $response->json()];

        } catch (\Exception $e) {
            Log::error('Groq Service Exception: ' . $e->getMessage());
            return ['error' => 'Something went wrong', 'message' => $e->getMessage()];
        }
    }
}
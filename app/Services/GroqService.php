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
                        'content' => "You are a professional chef. 
                                    Generate a recipe based on the ingredients provided. 
                                    CRITICAL: You must detect the language used in the ingredients list and respond entirely in that same language. 
                                    If the user types in Arabic, answer in Arabic. If in French, answer in French. 

                                    RULES:
                                    1. Return ONLY a valid JSON object.
                                    2. Do not include any explanation, markdown, or text outside JSON.
                                    3. Use exact keys: 'name', 'description', 'preparation_steps', 'cook_time', 'difficulty', 'country_origin'.
                                    4. 'cook_time' must be an integer (minutes).
                                    5. 'preparation_steps' should be a single string with steps separated by newline '\\n'.
                                    6. 'difficulty' should be: 'Easy', 'Medium', or 'Hard'.
                                    7. 'country_origin' should be a logical country based on ingredients.
                                    8. If ingredients are mismatched, try to find the most logical dish."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Suggest a recipe using these ingredients: " . $ingredientsString
                    ]
                ],
                'temperature' => 0.5,
            ]);

            
            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '{}';

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

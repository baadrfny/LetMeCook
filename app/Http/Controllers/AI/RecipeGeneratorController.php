<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Services\GroqService;
use Illuminate\Http\Request;

class RecipeGeneratorController extends Controller
{




    public function showAiGenerator()
{
    $ingredients = Ingredient::all(); 
    return view('ai.ai-generator', compact('ingredients')); 
}










    public function index(){
        $ingredients = Ingredient::all();
        return view('ai.ai-generator' , compact('ingredients'));
    }

    public function generate(Request $request, GroqService $groq)
    {
        $request->validate([
            'ingredients' => 'required|string|min:3'
        ]);

        // Split the string by commas and clean up
        $ingredients = array_map('trim', explode(',', $request->ingredients));
        $ingredients = array_filter($ingredients, function($item) {
            return !empty($item);
        });
        
        $recipe = $groq->generateRecipe($ingredients);

        if (isset($recipe['error'])) {
            return response()->json(['message' => 'AI is busy, try again!'], 500);
        }
        
        return response()->json($recipe);
    }
}

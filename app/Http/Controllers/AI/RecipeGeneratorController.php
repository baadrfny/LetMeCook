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
    // جلب المكونات ليعرضها للعميل ليختار منها
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
            'ingredients' => 'required|array|min:2'
        ]);

        $ingredientNames = Ingredient::whereIn('id', $request->ingredients)->pluck('name')->toArray();
        
        $recipe = $groq->generateRecipe($ingredientNames);

        if (isset($recipe['error'])) {
            return response()->json(['message' => 'AI is busy, try again!'], 500);
        }

        return response()->json($recipe);
    }
}

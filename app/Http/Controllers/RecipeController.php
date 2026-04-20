<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Categories;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $recipes = Recipe::with('category')->latest()->get();
        $categories = Categories::all();
        return view('dashboard', compact('recipes', 'categories'));
    }

    public function myRecipesIndex()
    {
        $recipes = Recipe::where('user_id', auth()->id())->with('category')->latest()->get();
        return view('recipes.index', compact('recipes'));
    }

    public function adminIndex()
    {
        $recipes = Recipe::with(['category', 'user'])->latest()->get();
        return view('admin.dashboard', compact('recipes'));
    }

    public function create()
    {
        $categories = Categories::all();
        $ingredients = Ingredient::all();
        return view('recipes.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'preparation_steps' => 'required|string',
            'cook_time' => 'nullable|integer|min:1',
            'country_origin' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url',
            'ingredients' => 'nullable|array',
            'quantities' => 'nullable|array',
            'units' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $ingredientsIds = $request->input('ingredients', []);
        $quantities = $request->input('quantities', []);
        $units = $request->input('units', []);

        $recipeData = collect($validated)->except(['ingredients', 'quantities', 'units'])->toArray();
        $recipe = Recipe::create($recipeData + ['user_id' => auth()->id()]);

        if (!empty($ingredientsIds)) {
            $syncData = [];
            foreach ($ingredientsIds as $id) {
                $syncData[$id] = [
                    'quantity' => $quantities[$id] ?? '0',
                    'unit' => $units[$id] ?? 'pcs'
                ];
            }
            $recipe->ingredients()->sync($syncData);
        }

        return redirect()->route('my-recipes.index')->with('success', 'Recipe created successfully!');
    }

    public function edit(Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $categories = Categories::all();
        $ingredients = Ingredient::all();
        $recipeIngredients = $recipe->ingredients->pluck('id')->toArray();

        return view('recipes.edit', compact('recipe', 'categories', 'ingredients', 'recipeIngredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'preparation_steps' => 'required|string',
            'cook_time' => 'nullable|integer|min:1',
            'country_origin' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url',
            'ingredients' => 'nullable|array',
            'quantities' => 'nullable|array',
            'units' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $ingredientsIds = $request->input('ingredients', []);
        $quantities = $request->input('quantities', []);
        $units = $request->input('units', []);

        $recipeUpdateData = collect($validated)->except(['ingredients', 'quantities', 'units'])->toArray();
        $recipe->update($recipeUpdateData);

        $syncData = [];
        foreach ($ingredientsIds as $id) {
            $syncData[$id] = [
                'quantity' => $quantities[$id] ?? '0',
                'unit' => $units[$id] ?? 'pcs'
            ];
        }
        $recipe->ingredients()->sync($syncData);

        return redirect()->route('my-recipes.index')->with('success', 'Recipe updated successfully!');
    }

    public function destroy(Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();
        return redirect()->route('my-recipes.index')->with('success', 'Recipe deleted!');
    }

    public function show($id)
    {
        $recipe = Recipe::with(['category', 'ingredients', 'user'])->findOrFail($id);
        
        $videoId = null;
        if ($recipe->video_url) {
            if (str_contains($recipe->video_url, 'youtu.be/')) {
                $videoId = explode('youtu.be/', $recipe->video_url)[1];
                $videoId = explode('?', $videoId)[0];
            } else {
                parse_str(parse_url($recipe->video_url, PHP_URL_QUERY), $vars);
                $videoId = $vars['v'] ?? null;
            }
        }
        
        return view('recipes.show', compact('recipe', 'videoId'));
    }
}
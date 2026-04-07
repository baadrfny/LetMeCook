<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * RecipeController handles CRUD operations for recipes.
 * 
 * This controller manages recipe creation, editing, viewing, and deletion
 * with proper validation and authorization checks.
 */

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category')->latest()->get();
        return view('dashboard', compact('recipes'));
    }

    public function adminIndex()
    {
        $recipes = Recipe::with('category', 'user')->latest()->get();
        return view('admin.dashboard', compact('recipes'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'preparation_steps' => 'nullable|string',
            'cook_time' => 'nullable|integer|min:1',
            'country_origin' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url',
        ]);

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
            $validated['image'] = $imagePath;
        }

        Recipe::create($validated + ['user_id' => auth()->id()]);

        return redirect()->route('admin.dashboard')->with('success', 'Recipe created!');
    }

    public function edit(Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }
        $categories = Categories::all();
        return view('recipes.edit', compact('recipe', 'categories'));
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
            'preparation_steps' => 'nullable|string',
            'cook_time' => 'nullable|integer|min:1',
            'country_origin' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url',
        ]);

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
            $validated['image'] = $imagePath;
        }

        $recipe->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Recipe updated!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Recipe deleted!');
    }

    public function show($id)
    {
        $recipe = Recipe::with(['category', 'user', 'ingredients'])->findOrFail($id);
        
        $videoId = null;
        if ($recipe->video_url) {
            // Extract video ID using parse_url and parse_str
            $urlParts = parse_url($recipe->video_url);
            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $vars);
                $videoId = $vars['v'] ?? '';
            }
            
            // Handle youtu.be format
            if (empty($videoId) && str_contains($recipe->video_url, 'youtu.be/')) {
                $videoId = explode('youtu.be/', $recipe->video_url)[1];
                $videoId = explode('?', $videoId)[0];
            }
        }
        
        return view('admin.show', compact('recipe', 'videoId'));
    }
}

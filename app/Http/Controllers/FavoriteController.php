<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('recipe.category')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function indexShow()
    {
        $favorites = auth()->user()->favorites()->with('recipe.category')->get();
        return view('recipes.show', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
        ]);

        $userId = auth()->id();
        $recipeId = $request->recipe_id;

        $alreadyExists = Favorite::where('user_id', $userId)
                                 ->where('recipe_id', $recipeId)
                                 ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with('error', 'This recipe is already in your favorites!');
        }

        Favorite::create([
            'user_id' => $userId,
            'recipe_id' => $recipeId,
        ]);

        return redirect()->back()->with('success', 'Recipe added to favorites!');
    }

    public function destroy(Favorite $favorite)
    {
        // Check if the favorite belongs to the authenticated user
        if ($favorite->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }

        $favorite->delete();
        return redirect()->back()->with('success', 'Recipe removed from favorites!');
    }
}

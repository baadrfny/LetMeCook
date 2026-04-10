<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AI\RecipeGeneratorController;
use App\Services\GroqService;

use Illuminate\Support\Facades\Route;





// مسار صفحة "ماذا يوجد في ثلاجتي؟" للعميل
Route::get('/what-to-cook', [RecipeGeneratorController::class, 'showAiGenerator'])->name('client.ai.index');
// مسار استقبال الطلب من العميل
Route::post('/ai/generate-guest', [RecipeGeneratorController::class, 'generate'])->name('ai.generate.guest');








Route::get('/', function () {
    return view('welcome');
});

/**
 * Shared Dashboard Route
 * Redirects users to their specific dashboard based on their role
 */
Route::get('/dashboard', [RecipeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/test-ai', function (GroqService $groq) {
    $result = $groq->generateRecipe(['chicken', 'garlic', 'lemon', 'olive oil']);
    
    dd($result); 
});

Route::get('/ai-generator', [RecipeGeneratorController::class, 'index'])->name('ai.index');
Route::post('/ai/generate', [RecipeGeneratorController::class, 'generate'])->name('ai.generate');
/**
 * User Routes (Standard Authenticated Users)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index')->middleware('auth');
    Route::post('/favorites/store', [FavoriteController::class, 'store'])->name('favorites.store')->middleware('auth');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy')->middleware('auth');
    
    // User Recipe Management
    Route::get('/my-recipes', [RecipeController::class, 'myRecipesIndex'])->name('my-recipes.index');
    Route::get('/my-recipes/create', [RecipeController::class, 'create'])->name('my-recipes.create');
    Route::post('/my-recipes', [RecipeController::class, 'store'])->name('my-recipes.store');
    Route::get('/my-recipes/{recipe}', [RecipeController::class, 'show'])->name('my-recipes.show');
    Route::get('/my-recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('my-recipes.edit');
    Route::put('/my-recipes/{recipe}', [RecipeController::class, 'update'])->name('my-recipes.update');
    Route::delete('/my-recipes/{recipe}', [RecipeController::class, 'destroy'])->name('my-recipes.destroy');
    
    // Ingredients Management
    Route::get('/ingredients/list', [IngredientController::class, 'IngredientList'])->name('ingredients.list');
});

/**
 * Admin Routes (Protected by AdminMiddleware)
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [RecipeController::class, 'adminIndex'])->name('admin.dashboard');

    // Admin Specific Management
    Route::resource('categories', CategoryController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('countries', CountryController::class);
    
    // Admin Recipe Management
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    
    // Admin view of all recipes
    Route::get('/all-recipes', [RecipeController::class, 'adminIndex'])->name('admin.recipes.index');
});

require __DIR__.'/auth.php';
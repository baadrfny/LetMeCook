<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            (new ConsoleOutput())->writeln('<comment>RecipeSeeder skipped: no existing users found.</comment>');

            return;
        }

        $recipes = [
            [
                'name' => 'Classic Spaghetti Carbonara',
                'description' => 'A creamy Italian pasta dish with eggs, cheese, and pancetta.',
                'category' => 'Dinner',
                'preparation_steps' => "1. Boil pasta in salted water\n2. Cook pancetta until crispy\n3. Mix eggs and parmesan\n4. Combine pasta with pancetta\n5. Remove from heat and mix in egg mixture\n6. Serve immediately with black pepper",
                'cook_time' => 25,
                'country_origin' => 'Italy',
                'video_url' => 'https://example.com/carbonara',
                'ingredients' => [
                    ['name' => 'Pasta', 'quantity' => '400', 'unit' => 'g'],
                    ['name' => 'Eggs', 'quantity' => '3', 'unit' => 'pieces'],
                    ['name' => 'Parmesan Cheese', 'quantity' => '100', 'unit' => 'g'],
                    ['name' => 'Black Pepper', 'quantity' => '1', 'unit' => 'tsp'],
                ],
            ],
            [
                'name' => 'Grilled Lemon Herb Chicken',
                'description' => 'Juicy chicken breast marinated in lemon and herbs.',
                'category' => 'Dinner',
                'preparation_steps' => "1. Mix olive oil, lemon juice, and herbs\n2. Marinate chicken for 2 hours\n3. Preheat grill to medium-high\n4. Grill chicken 6-7 minutes per side\n5. Let rest for 5 minutes\n6. Serve with fresh herbs",
                'cook_time' => 30,
                'country_origin' => 'Mediterranean',
                'video_url' => null,
                'ingredients' => [
                    ['name' => 'Chicken Breast', 'quantity' => '4', 'unit' => 'pieces'],
                    ['name' => 'Olive Oil', 'quantity' => '3', 'unit' => 'tbsp'],
                    ['name' => 'Lemon', 'quantity' => '2', 'unit' => 'pieces'],
                    ['name' => 'Basil', 'quantity' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Garlic', 'quantity' => '3', 'unit' => 'cloves'],
                    ['name' => 'Salt', 'quantity' => '1', 'unit' => 'tsp'],
                ],
            ],
            [
                'name' => 'Vegetable Stir Fry',
                'description' => 'Quick and healthy vegetable stir fry with soy sauce.',
                'category' => 'Vegetarian',
                'preparation_steps' => "1. Chop all vegetables\n2. Heat oil in wok\n3. Stir fry vegetables 3-4 minutes\n4. Add soy sauce and garlic\n5. Cook for 1 more minute\n6. Serve with rice",
                'cook_time' => 15,
                'country_origin' => 'China',
                'video_url' => null,
                'ingredients' => [
                    ['name' => 'Bell Peppers', 'quantity' => '2', 'unit' => 'pieces'],
                    ['name' => 'Carrots', 'quantity' => '2', 'unit' => 'pieces'],
                    ['name' => 'Onion', 'quantity' => '1', 'unit' => 'piece'],
                    ['name' => 'Garlic', 'quantity' => '3', 'unit' => 'cloves'],
                    ['name' => 'Soy Sauce', 'quantity' => '3', 'unit' => 'tbsp'],
                    ['name' => 'Olive Oil', 'quantity' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Rice', 'quantity' => '200', 'unit' => 'g'],
                ],
            ],
            [
                'name' => 'Classic Pancakes',
                'description' => 'Fluffy breakfast pancakes perfect for Sunday mornings.',
                'category' => 'Breakfast',
                'preparation_steps' => "1. Mix flour, baking powder, salt, and sugar\n2. Whisk in milk and eggs\n3. Heat pan with butter\n4. Pour batter and cook until bubbles form\n5. Flip and cook other side\n6. Serve with syrup",
                'cook_time' => 20,
                'country_origin' => 'USA',
                'video_url' => 'https://example.com/pancakes',
                'ingredients' => [
                    ['name' => 'Flour', 'quantity' => '200', 'unit' => 'g'],
                    ['name' => 'Milk', 'quantity' => '300', 'unit' => 'ml'],
                    ['name' => 'Eggs', 'quantity' => '2', 'unit' => 'pieces'],
                    ['name' => 'Butter', 'quantity' => '50', 'unit' => 'g'],
                    ['name' => 'Sugar', 'quantity' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Baking Powder', 'quantity' => '2', 'unit' => 'tsp'],
                    ['name' => 'Salt', 'quantity' => '1/4', 'unit' => 'tsp'],
                ],
            ],
            [
                'name' => 'Garlic Butter Shrimp',
                'description' => 'Quick 10-minute shrimp in garlic butter sauce.',
                'category' => 'Seafood',
                'preparation_steps' => "1. Melt butter in pan\n2. Add minced garlic\n3. Add shrimp and cook 2 minutes per side\n4. Season with salt and pepper\n5. Add lemon juice\n6. Garnish with parsley and serve",
                'cook_time' => 10,
                'country_origin' => 'USA',
                'video_url' => null,
                'ingredients' => [
                    ['name' => 'Shrimp', 'quantity' => '500', 'unit' => 'g'],
                    ['name' => 'Butter', 'quantity' => '4', 'unit' => 'tbsp'],
                    ['name' => 'Garlic', 'quantity' => '4', 'unit' => 'cloves'],
                    ['name' => 'Lemon', 'quantity' => '1', 'unit' => 'piece'],
                    ['name' => 'Salt', 'quantity' => '1/2', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'quantity' => '1/4', 'unit' => 'tsp'],
                ],
            ],
        ];

        foreach ($recipes as $recipeData) {
            $category = Categories::where('name', $recipeData['category'])->first();

            if (! $category) {
                continue;
            }

            $recipe = Recipe::updateOrCreate([
                'user_id' => $user->id,
                'name' => $recipeData['name'],
            ], [
                'name' => $recipeData['name'],
                'description' => $recipeData['description'],
                'category_id' => $category->id,
                'preparation_steps' => $recipeData['preparation_steps'],
                'cook_time' => $recipeData['cook_time'],
                'country_origin' => $recipeData['country_origin'],
                'video_url' => $recipeData['video_url'],
                'image' => null,
                'suggestion_date' => null,
            ]);

            $syncData = [];

            foreach ($recipeData['ingredients'] as $ingredientData) {
                $ingredient = Ingredient::where('name', $ingredientData['name'])->first();
                
                if ($ingredient) {
                    $syncData[$ingredient->id] = [
                        'quantity' => $ingredientData['quantity'],
                        'unit' => $ingredientData['unit'],
                    ];
                }
            }

            $recipe->ingredients()->sync($syncData);
        }
    }
}

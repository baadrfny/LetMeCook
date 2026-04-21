<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Flour', 'category' => 'Baking'],
            ['name' => 'Sugar', 'category' => 'Baking'],
            ['name' => 'Salt', 'category' => 'Spices'],
            ['name' => 'Black Pepper', 'category' => 'Spices'],
            ['name' => 'Olive Oil', 'category' => 'Oils'],
            ['name' => 'Butter', 'category' => 'Dairy'],
            ['name' => 'Milk', 'category' => 'Dairy'],
            ['name' => 'Eggs', 'category' => 'Dairy'],
            ['name' => 'Chicken Breast', 'category' => 'Meat'],
            ['name' => 'Beef', 'category' => 'Meat'],
            ['name' => 'Salmon', 'category' => 'Seafood'],
            ['name' => 'Shrimp', 'category' => 'Seafood'],
            ['name' => 'Tomatoes', 'category' => 'Vegetables'],
            ['name' => 'Onion', 'category' => 'Vegetables'],
            ['name' => 'Garlic', 'category' => 'Vegetables'],
            ['name' => 'Potatoes', 'category' => 'Vegetables'],
            ['name' => 'Carrots', 'category' => 'Vegetables'],
            ['name' => 'Bell Peppers', 'category' => 'Vegetables'],
            ['name' => 'Rice', 'category' => 'Grains'],
            ['name' => 'Pasta', 'category' => 'Grains'],
            ['name' => 'Basil', 'category' => 'Herbs'],
            ['name' => 'Oregano', 'category' => 'Herbs'],
            ['name' => 'Parmesan Cheese', 'category' => 'Dairy'],
            ['name' => 'Lemon', 'category' => 'Fruits'],
            ['name' => 'Lime', 'category' => 'Fruits'],
            ['name' => 'Honey', 'category' => 'Condiments'],
            ['name' => 'Soy Sauce', 'category' => 'Condiments'],
            ['name' => 'Vinegar', 'category' => 'Condiments'],
            ['name' => 'Yeast', 'category' => 'Baking'],
            ['name' => 'Baking Powder', 'category' => 'Baking'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::firstOrCreate(
                ['name' => $ingredient['name']],
                ['category' => $ingredient['category']]
            );
        }
    }
}

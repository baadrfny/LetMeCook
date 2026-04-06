<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Breakfast',
            'Lunch',
            'Dinner',
            'Dessert',
            'Appetizer',
            'Snack',
            'Beverage',
            'Salad',
            'Soup',
            'Vegetarian',
            'Vegan',
            'Seafood',
            'Meat',
            'Pasta',
            'Baking',
        ];

        foreach ($categories as $name) {
            Categories::create(['name' => $name]);
        }
    }
}

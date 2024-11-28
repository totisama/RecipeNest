<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rodrigo Sama',
            'email' => 'toti@gmail.com',
            'password' => '$2y$12$nJT5MdPhGzDqNZFfbjxCL.gROd37N0Y/f6mSx7dxV67Uju5Jtza/S',
        ]);

        $ingredients = [
            'Flour',
            'Sugar',
            'Salt',
            'Butter',
            'Eggs',
            'Milk',
            'Cheese',
            'Tomatoes',
            'Chicken',
            'Beef',
            'Carrots',
            'Onions',
            'Garlic',
            'Potatoes',
            'Peppers',
            'Rice',
            'Pasta',
            'Chocolate',
            'Vanilla',
            'Yeast',
            'Spinach',
            'Basil',
            'Parsley',
            'Cinnamon',
            'Ginger',
            'Honey',
            'Lemon',
            'Orange',
            'Fish',
        ];

        foreach ($ingredients as $ingredientName) {
            $ingredient = Ingredient::create([
                'name' => $ingredientName,
            ]);
        }

        $numRecipes = 10;
        for ($i = 0; $i < $numRecipes; $i++) {

            $recipe = Recipe::create([
                'title' => fake()->words(3, true),
                'total_time' => fake()->numberBetween(10, 120),
                'description' => fake()->paragraph(3),
                'user_id' => 1,
            ]);

            $numSteps = fake()->numberBetween(3, 8);
            for ($step = 1; $step <= $numSteps; $step++) {
                $recipeStep = Step::create([
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(2),
                    'order' => $step,
                    'recipe_id' => $recipe->id,
                ]);

                $numIngredients = fake()->numberBetween(1, 5);
                for ($j = 0; $j < $numIngredients; $j++) {
                    $ingredient = Ingredient::inRandomOrder()->first();

                    $recipeStep->ingredients()->attach($ingredient->id, [
                        'amount' => fake()->randomFloat(2, 0.1, 10),
                        'unit' => fake()->randomElement(Ingredient::getUnits()->toArray()),
                    ]);
                }
            }
        }
    }
}

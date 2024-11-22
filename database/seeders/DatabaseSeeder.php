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
        $user = User::create([
            'name' => 'Rodrigo Sama',
            'email' => 'toti@gmail.com',
            'password' => '$2y$12$nJT5MdPhGzDqNZFfbjxCL.gROd37N0Y/f6mSx7dxV67Uju5Jtza/S',
        ]);

        $users = User::factory(1)->create();

        $users->prepend($user);

        $recipes = Recipe::factory(10)->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        $ingredients = Ingredient::factory(50)->create();

        $recipes->each(function ($recipe) use ($ingredients) {
            $steps = Step::factory(rand(3, 8))->create([
                'recipe_id' => $recipe->id,
            ]);

            $steps->each(function ($step) use ($ingredients) {
                $randomIngredients = $ingredients->random(rand(2, 5));

                foreach ($randomIngredients as $ingredient) {
                    $step->ingredients()->attach($ingredient->id, [
                        'amount' => fake()->randomFloat(2, 0.1, 5), // Random amount for each ingredient
                        'unit' => fake()->randomElement(['grams', 'kilograms', 'liters', 'milliliters', 'pounds', 'ounces']),
                    ]);
                }
            });
        });
    }
}

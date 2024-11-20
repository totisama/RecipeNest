<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientStep>
 */
class IngredientStepFactory extends Factory
{
    public function definition()
    {
        return [
            'step_id' => Step::factory(),
            'ingredient_id' => Ingredient::factory(),
            'amount' => $this->faker->randomFloat(2, 0.1, 10),
        ];
    }
}

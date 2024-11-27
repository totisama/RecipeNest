<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'total_time' => $this->faker->numberBetween(10, 120),
            'description' => $this->faker->paragraph,
            'user_id' => User::factory(),
        ];
    }
}

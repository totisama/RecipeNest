<?php

use App\Models\Ingredient;
use App\Models\User;

test('Ingredients page doesnt renders without user', function () {
    $response = $this->get('/user/ingredients');

    $response->assertRedirect('/login');
});

test('Ingredients page renders with user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/user/ingredients');

    $response->assertStatus(200);
});

test('Ingredients are correclly shown', function () {
    $ingredients = Ingredient::factory(5)->create();

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/user/ingredients');

    foreach ($ingredients as $ingredient) {
        $response->assertSee($ingredient->name);
    }
});

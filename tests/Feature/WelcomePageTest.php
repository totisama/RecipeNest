<?php

use App\Models\Recipe;

test('Welcome page renders correctly', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('Recipes are correclly shown', function () {
    $recipes = Recipe::factory(5)->create();

    $response = $this->get('/');

    foreach ($recipes as $recipe) {
        $response->assertSee($recipe->title);
    }
});

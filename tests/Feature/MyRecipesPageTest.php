<?php

use App\Models\Recipe;
use App\Models\User;

test('My recipes page doesnt renders without user', function () {
    $response = $this->get('/user/ingredients');

    $response->assertRedirect('/login');
});

test('My recipes page renders with user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/user/recipes');

    $response->assertStatus(200);
});

test('My recipes are correclly shown', function () {
    $user = User::factory()->create();
    $recipes = Recipe::factory(5)->for($user)->create();

    $response = $this->actingAs($user)->get('/user/recipes');

    foreach ($recipes as $recipe) {
        $response->assertSee($recipe->title);
    }
});

test('Can see only my recipes', function () {
    $user = User::factory()->create();

    $myRecipes = Recipe::factory(3)->for($user)->create();
    $notMyRecipes = Recipe::factory(2)->create();

    $response = $this->actingAs($user)->get('/user/recipes');

    foreach ($myRecipes as $recipe) {
        $response->assertSee($recipe->title);
    }

    foreach ($notMyRecipes as $recipe) {
        $response->assertDontSee($recipe->title);
    }
});

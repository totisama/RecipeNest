<?php

use App\Livewire\RecipeFilter;
use Livewire\Livewire;

test('RecipeFilter component renders correctly', function () {
    Livewire::test(RecipeFilter::class, ['recipes' => []])
        ->assertSee('Search recipes...')
        ->assertSee('Search')
        ->assertSee('No recipes found');
});

test('RecipeFilter component shows recipes', function () {
    $recipes = [
        ['id' => 1, 'title' => 'Pasta', 'image' => null, 'steps' => 5, 'total_time' => 30],
        ['id' => 2, 'title' => 'Salad', 'image' => null, 'steps' => 3, 'total_time' => 15],
    ];

    Livewire::test(RecipeFilter::class, ['recipes' => $recipes])
        ->assertSee('Pasta')
        ->assertSee('5 steps')
        ->assertSee('30')
        ->assertSee('Salad')
        ->assertSee('3 steps')
        ->assertSee('15');
});

test('RecipeFilter shows no recipes message for empty results', function () {
    Livewire::test(RecipeFilter::class, ['recipes' => []])
        ->set('query', 'NonExistentRecipe')
        ->call('fetchRecipes')
        ->assertSee('No recipes found.');
});

test('RecipeFilter shows recipe after query', function () {
    $mockedRecipes = [
        ['id' => 1, 'title' => 'Pasta', 'image' => null, 'steps' => 5, 'total_time' => '30 min'],
    ];

    Cache::shouldReceive('remember')
        ->once()
        ->with('pasta', 3600, \Closure::class)
        ->andReturn($mockedRecipes);

    Livewire::test(RecipeFilter::class, ['recipes' => []])
        ->set('query', 'pasta')
        ->call('fetchRecipes')
        ->assertSee('Pasta')
        ->assertDontSee('No recipes found.');
});

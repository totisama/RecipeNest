<?php

use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::resource('recipes', RecipeController::class)->only(['index', 'show']);
    Route::apiResource('ingredients', IngredientController::class);
});

<?php

use App\Http\Controllers\Api\RecipeController;
use Illuminate\Support\Facades\Route;

Route::resource('recipes', RecipeController::class)->only(['index', 'show']);
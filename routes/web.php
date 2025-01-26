<?php

use App\Http\Controllers\PartnerRecipesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('welcome');

Route::get('/partner-recipes', PartnerRecipesController::class)->name('partner-recipes');
Route::get('/partner-recipes/{id}', [PartnerRecipesController::class, 'show'])->name('partner-recipes.show');

Route::get('recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('recipes/{id}/start', [RecipeController::class, 'start'])->name('recipes.start');

Route::prefix('user')->middleware(['auth', 'verified'])->name('user.')->group(function () {
    Route::resource('recipes', App\Http\Controllers\User\RecipeController::class);
    Route::resource('ingredients', App\Http\Controllers\User\IngredientController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

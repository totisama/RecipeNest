<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeIndexResource;
use App\Http\Resources\RecipeShowResource;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('steps', 'steps.ingredients', 'steps.ingredients.media')->paginate(5);

        return RecipeIndexResource::collection($recipes);
    }

    public function show(int $id)
    {
        $recipe = Recipe::with('steps', 'steps.ingredients', 'steps.ingredients.media')->findOrFail($id);

        return new RecipeShowResource($recipe);
    }
}
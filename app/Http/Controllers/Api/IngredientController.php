<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index()
    {
        $recipes = Ingredient::paginate(10);

        return IngredientResource::collection($recipes);
    }

    public function show(int $id)
    {
        $recipe = Ingredient::findOrFail($id);

        return new IngredientResource($recipe);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class RecipeController extends Controller
{
    public function show(int $id)
    {
        $recipe = Recipe::where('id', $id)->first();

        if ($recipe === null) {
            abort(404);
        }

        return view('recipes.show')->with('recipe', $recipe);
    }
}

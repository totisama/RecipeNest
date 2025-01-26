<?php

namespace App\Http\Controllers;

use App\Services\Endpoints;
use App\Services\TastyService;

class PartnerRecipesController extends Controller
{
    public function __invoke()
    {
        $instance = new TastyService;
        $recipes = $instance->getRecipes();

        return view('partner-recipes')->with('recipes', $recipes);
    }

    public function show(int $id)
    {
        $instance = new TastyService(Endpoints::SPECIFIC);
        $recipe = $instance->getRecipe($id);

        if (! $recipe) {
            abort(404);
        }

        return view('partner-recipes.show')->with('recipe', $recipe);
    }
}

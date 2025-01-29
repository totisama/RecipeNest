<?php

namespace App\Http\Controllers;

use App\Services\Endpoints;
use App\Services\TastyService;

class PartnerRecipesController extends Controller
{
    public function __invoke()
    {
        $recipes = cache()->remember('parter_recipes', 3600, function () {
            $instance = new TastyService;

            return $instance->getRecipes();
        });

        return view('partner-recipes')->with('recipes', $recipes);
    }

    public function show(int $id)
    {
        $recipe = cache()->remember('partner_recipe_'.$id, 3600, function () use ($id) {
            $instance = new TastyService(Endpoints::SPECIFIC);

            return $instance->getRecipe($id);
        });

        if (! $recipe) {
            abort(404);
        }

        return view('partner-recipes.show')->with('recipe', $recipe);
    }
}

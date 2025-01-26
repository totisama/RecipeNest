<?php

namespace App\Http\Controllers;

use App\Services\RecipesService;

class PartnerRecipesController extends Controller
{
    public function __invoke()
    {
        $instance = new RecipesService;
        $recipes = $instance->getRecipes();

        return view('partner-recipes')->with('recipes', $recipes);
    }
}
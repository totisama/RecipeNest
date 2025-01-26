<?php

namespace App\Http\Controllers;

use App\Services\TastyService;

class PartnerRecipesController extends Controller
{
    public function __invoke()
    {
        $instance = new TastyService;
        $recipes = $instance->getRecipes();

        return view('partner-recipes')->with('recipes', $recipes);
    }
}

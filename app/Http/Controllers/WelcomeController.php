<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $recipes = Recipe::all();

        $recipes->load('steps', 'media');

        return view('welcome')->with('recipes', $recipes);
    }
}

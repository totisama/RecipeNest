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

        $recipe->load('steps', 'steps.ingredients', 'steps.ingredients.media');

        $recipe->steps = $recipe->steps->sortBy('order');

        return view('recipes.show')->with('recipe', $recipe);
    }

    public function start(int $id)
    {
        $recipe = Recipe::where('id', $id)->first();

        if ($recipe === null) {
            abort(404);
        }

        $currentStepNumber = request('step');

        if ($currentStepNumber === null) {
            $currentStepNumber = 1;
        }

        $steps = $recipe->steps;

        if (! is_numeric($currentStepNumber) || $currentStepNumber > $steps->count()) {
            abort(404);
        }

        $step = $steps->firstWhere('order', $currentStepNumber);
        $step->load('ingredients', 'ingredients.media');

        if (! $step) {
            abort(404);
        }

        $nextStepNumber = null;
        $previousStepNumber = null;

        if ($currentStepNumber < $steps->count()) {
            $nextStepNumber = $currentStepNumber + 1;
        }

        if ($currentStepNumber > 1) {
            $previousStepNumber = $currentStepNumber - 1;
        }

        return view('recipes.start', compact(['recipe', 'nextStepNumber', 'previousStepNumber', 'step']));
    }
}

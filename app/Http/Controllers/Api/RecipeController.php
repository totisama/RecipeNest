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
        $recipe = Recipe::with('steps', 'steps.ingredients', 'steps.ingredients.media')->find($id);

        if (! $recipe) {
            return response()->json([
                'message' => 'Recipe not found!',
            ], 404);
        }

        return new RecipeShowResource($recipe);
    }

    public function destroy(string $id)
    {
        $recipe = Recipe::find($id);

        if (! $recipe) {
            return response()->json([
                'message' => 'Recipe not found!',
            ], 404);
        }

        if ($recipe->user_id != auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized!',
            ], 401);
        }

        $recipe->isAuthorized(auth()->user());

        $recipe->delete();

        return response()->json([
            'message' => 'Recipe deleted successfully!',
        ]);
    }
}

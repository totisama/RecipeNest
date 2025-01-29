<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeIndexResource;
use App\Http\Resources\RecipeShowResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        if ($request->has('steps') && is_string($request->steps)) {
            $request->merge([
                'steps' => json_decode($request->steps, true),
            ]);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'total_time' => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string'],
            'steps' => ['required', 'array', 'min:1'],
            'image' => ['required', 'file', 'image', 'max:1024'],
            'steps.*.title' => ['required', 'string'],
            'steps.*.description' => ['required', 'string'],
            'steps.*.step_number' => ['required', 'numeric'],
            'steps.*.ingredients' => ['required', 'array', 'min:1'],
            'steps.*.ingredients.*.id' => ['required', 'string', 'exists:ingredients,id'],
            'steps.*.ingredients.*.amount' => ['required', 'numeric', 'min:1'],
            'steps.*.ingredients.*.unit' => ['required', 'string', 'in:'.Ingredient::getUnits()->implode(',')],
        ]);

        $orders = array_column($request->steps, 'step_number');
        if (count($orders) !== count(array_unique($orders))) {
            return response()->json([
                'message' => 'Step number must be unique!',
            ], 422);
        }

        $recipe = Recipe::create([
            'title' => $request->title,
            'total_time' => $request->total_time,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);

        $recipe->addMediaFromRequest('image')->toMediaCollection('images');

        $steps = $request->steps;

        foreach ($steps as $key => $value) {
            $step = Step::create([
                'title' => $value['title'],
                'description' => $value['description'],
                'order' => $value['step_number'],
                'recipe_id' => $recipe->id,
            ]);

            foreach ($value['ingredients'] as $ingredient) {
                $step->ingredients()->attach($ingredient['id'], [
                    'amount' => $ingredient['amount'],
                    'unit' => $ingredient['unit'],
                ]);
            }
        }

        return response()->json([
            'message' => 'Recipe created successfully!',
            'recipe' => new RecipeShowResource($recipe),
        ]);
    }

    public function update(Request $request, string $id)
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

        if ($request->has('steps') && is_string($request->steps)) {
            $request->merge([
                'steps' => json_decode($request->steps, true),
            ]);
        }
        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'total_time' => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.id' => ['sometimes', 'string'],
            'steps.*.title' => ['required', 'string'],
            'steps.*.description' => ['required', 'string'],
            'steps.*.step_number' => ['required', 'numeric'],
            'steps.*.ingredients' => ['required', 'array', 'min:1'],
            'steps.*.ingredients.*.id' => ['required', 'string', 'exists:ingredients,id'],
            'steps.*.ingredients.*.amount' => ['required', 'numeric', 'min:1'],
            'steps.*.ingredients.*.unit' => ['required', 'string', 'in:'.Ingredient::getUnits()->implode(',')],
        ]);

        $recipe->update([
            'title' => $request->title,
            'total_time' => $request->total_time,
            'description' => $request->description,
        ]);

        $steps = $request->steps;
        $existingStepIds = $recipe->steps()->pluck('id')->toArray();

        foreach ($steps as $key => $value) {
            // If step has an id, update it
            if (isset($value['id'])) {
                // Check if the step belongs to the recipe
                if (! in_array($value['id'], $existingStepIds)) {
                    continue;
                }

                $step = Step::find($value['id']);
                $step->update([
                    'title' => $value['title'],
                    'order' => $value['step_number'],
                    'description' => $value['description'],
                ]);

                $currentIngredientIds = $step->ingredients()->pluck('id')->toArray();
                $newIngredientIds = array_column($value['ingredients'], 'id');

                $ingredientsToDetach = array_diff($currentIngredientIds, $newIngredientIds);
                $step->ingredients()->detach($ingredientsToDetach);

                foreach ($value['ingredients'] as $ingredient) {
                    $step->ingredients()->syncWithoutDetaching([
                        $ingredient['id'] => [
                            'amount' => $ingredient['amount'],
                            'unit' => $ingredient['unit'],
                        ],
                    ]);
                }
            } else {
                $step = Step::create([
                    'title' => $value['title'],
                    'description' => $value['description'],
                    'order' => $key,
                    'recipe_id' => $recipe->id,
                ]);

                foreach ($value['ingredients'] as $ingredient) {
                    $step->ingredients()->attach($ingredient['id'], [
                        'amount' => $ingredient['amount'],
                        'unit' => $ingredient['unit'],
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Recipe updated successfully!',
            'recipe' => new RecipeShowResource($recipe),
        ]);
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

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        if (! $userId) {
            abort(401);
        }

        $recipes = Recipe::where('user_id', $userId)->get();

        return view('user.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ingredients = Ingredient::getAllIngredientsValueLabel();
        $units = Ingredient::getUnitsValueLabel();

        return view('user.recipes.create', compact(['ingredients', 'units']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        if (! $userId) {
            abort(401);
        }

        $data = $this->buildRulesAndDataStructure($request->all());
        $rules = $data[0];
        $steps = $data[1];

        session()->flash('stepsAmount', $steps);

        $request->validate($rules);

        $recipe = Recipe::create([
            'title' => $request->title,
            'total_time' => $request->total_time,
            'description' => $request->description,
            'user_id' => $userId,
            'image' => fake()->imageUrl(),
        ]);

        foreach ($steps as $key => $value) {
            $step = Step::create([
                'title' => $value['title'],
                'description' => $value['description'],
                'order' => $key,
                'recipe_id' => $recipe->id,
                'image' => fake()->imageUrl(),
            ]);

            foreach ($value['ingredients'] as $ingredient) {
                $step->ingredients()->attach($ingredient['id'], [
                    'amount' => $ingredient['amount'],
                    'unit' => $ingredient['unit'],
                ]);
            }
        }

        session()->flash('success', 'Recipe created successfully!');

        return redirect()->route('user.recipes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $recipe = Recipe::find($id);
        $recipe->isAuthorized(auth()->user());

        $steps = $recipe->steps->sortBy('order');
        $stepsObject = [];

        foreach ($steps as $stepKey => $step) {
            $stepKey += 1;

            if (! isset($stepsObject[$stepKey])) {
                $stepsObject[$stepKey] = [
                    'title' => $step->title,
                    'description' => $step->description,
                    'order' => $step->order,
                    'ingredients' => [],
                ];
            }

            $ingredients = $step->ingredients;

            foreach ($ingredients as $ingredientKey => $ingredient) {
                $ingredientKey += 1;

                $stepsObject[$stepKey]['ingredients'][$ingredientKey] = [
                    'id' => $ingredient->id,
                    'amount' => $ingredient->pivot->amount,
                    'unit' => $ingredient->pivot->unit,
                ];
            }
        }

        $ingredients = Ingredient::getAllIngredientsValueLabel();
        $units = Ingredient::getUnitsValueLabel();

        return view('user.recipes.edit', compact([
            'recipe',
            'stepsObject',
            'ingredients',
            'units',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::find($id);
        $recipe->isAuthorized(auth()->user());

        $data = $this->buildRulesAndDataStructure($request->all());
        $rules = $data[0];
        $steps = $data[1];

        session()->flash('stepsAmount', $steps);

        $request->validate($rules);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $recipe->isAuthorized(auth()->user());

        $recipe->delete();

        session()->flash('success', 'Article deleted successfully!');

        return redirect()->route('user.recipes.index');
    }

    private function buildRulesAndDataStructure($input)
    {
        $units = Ingredient::getUnits();
        $rules = [];
        $steps = [];

        foreach ($input as $key => $value) {
            // Dynamic validations
            $defaultRule = ['required', 'string'];

            if ($key === '_token') {
                continue;
            } elseif (str_contains($key, 'amount') || $key === 'total_time') {
                $defaultRule[1] = 'numeric';
            } elseif (str_contains($key, 'unit')) {
                array_push($defaultRule, Rule::in($units));
            }

            $rules[$key] = $defaultRule;

            // Dynamic data structure
            if (preg_match('/step(\d+)-(.+)/', $key, $matches)) {
                $stepNumber = $matches[1];
                $fieldType = $matches[2];

                if (! isset($steps[$stepNumber])) {
                    $steps[$stepNumber] = [
                        'title' => null,
                        'description' => null,
                        'ingredients' => [],
                    ];
                }

                if ($fieldType === 'title') {
                    $steps[$stepNumber]['title'] = $value;
                } elseif ($fieldType === 'description') {
                    $steps[$stepNumber]['description'] = $value;
                } elseif (preg_match('/ingredient(\d+)/', $fieldType, $ingredientMatches)) {
                    $ingredientNumber = $ingredientMatches[1];
                    $ingredientKey = str_replace("ingredient$ingredientNumber-", '', $fieldType);

                    if (! isset($steps[$stepNumber]['ingredients'][$ingredientNumber])) {
                        $steps[$stepNumber]['ingredients'][$ingredientNumber] = [
                            'id' => null,
                            'amount' => null,
                            'unit' => null,
                        ];
                    }

                    if ($ingredientKey === 'id') {
                        $steps[$stepNumber]['ingredients'][$ingredientNumber]['id'] = $value;
                    } elseif ($ingredientKey === 'amount') {
                        $steps[$stepNumber]['ingredients'][$ingredientNumber]['amount'] = $value;
                    } elseif ($ingredientKey === 'unit') {
                        $steps[$stepNumber]['ingredients'][$ingredientNumber]['unit'] = $value;
                    }
                }
            }
        }

        return [$rules, $steps];
    }
}

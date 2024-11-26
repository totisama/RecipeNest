<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
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
        $ingredients = Ingredient::all()->sortBy('name');

        $ingredients = $ingredients->map(function ($ingredient) {
            return ['value' => $ingredient->id, 'label' => $ingredient->name];
        });

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

        $units = Ingredient::getUnits();
        $input = $request->all();
        $rules = [];
        $steps = [];

        foreach ($input as $key => $value) {
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

        foreach ($input as $key => $value) {
            $defaultRule = ['required', 'string'];

            if ($key === '_token') {
                continue;
            } elseif (str_contains($key, 'amount') || $key === 'total_time') {
                $defaultRule[1] = 'number';
            } elseif (str_contains($key, 'unit')) {
                array_push($defaultRule, Rule::in($units));
            }

            $rules[$key] = $defaultRule;
        }
        dd($steps);

        $request->validate($rules);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
}

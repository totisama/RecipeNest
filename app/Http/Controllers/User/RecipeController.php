<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;

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
            return $ingredient->name;
        });
        $units = Ingredient::getUnits();

        return view('user.recipes.create', compact(['ingredients', 'units']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

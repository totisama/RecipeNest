<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
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

        $ingredients = Ingredient::all()->sortBy('name');
        $ingredients->load('media');

        return view('user.ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['required', 'file', 'image', 'max:1024'],
        ]);

        $userId = auth()->user()->id;

        if (! $userId) {
            abort(401);
        }

        $ingredient = Ingredient::create([
            'name' => $request->name,
        ]);

        $ingredient->addMediaFromRequest('image')->toMediaCollection('images');

        session()->flash('success', 'Ingredient created successfully!');

        return redirect()->route('user.ingredients.index');
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
        $ingredient = Ingredient::findOrFail($id);

        if (auth()->user() === null) {
            abort(401);
        }

        if (count($ingredient->steps) > 0) {
            session()->flash('error', 'Ingredient is in use and cannot be deleted!');

            return redirect()->route('user.ingredients.index');
        }

        $ingredient->delete();

        session()->flash('success', 'Ingredient deleted successfully!');

        return redirect()->route('user.ingredients.index');
    }
}

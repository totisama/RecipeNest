<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::paginate(10);

        return IngredientResource::collection($ingredients);
    }

    public function show(int $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        return new IngredientResource($ingredient);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            // 'image' => ['required', 'file', 'image', 'max:1024'],
        ]);

        $ingredient = Ingredient::create([
            'name' => $request->name,
        ]);

        // $ingredient->addMediaFromRequest('image')->toMediaCollection('images');

        return new IngredientResource($ingredient);
    }
}

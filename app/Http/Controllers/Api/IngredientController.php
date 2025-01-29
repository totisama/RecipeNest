<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'value' => ['nullable', 'string', 'max:255'],
            'size' => ['nullable', 'integer', 'min:1', 'max:50'],
            'sort_by' => ['nullable', 'string', 'in:id,name,created_at'],
            'sort_order' => ['nullable', 'string', 'in:asc,desc'],
        ]);

        $query = Ingredient::query();

        if ($request->has('value')) {
            $query->where('name', 'like', '%'.$request->query('value').'%');
        }

        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $size = $request->query('size', 10);
        $ingredients = $query->paginate((int) $size);

        return IngredientResource::collection($ingredients);
    }

    public function show(int $id)
    {
        $ingredient = Ingredient::find($id);

        if (! $ingredient) {
            return response()->json([
                'message' => 'Ingredient not found!',
            ], 404);
        }

        return new IngredientResource($ingredient);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['required', 'file', 'image', 'max:1024'],
        ]);

        $existingIngredient = Ingredient::where('name', 'like', '%'.$request->name.'%')->first();

        if ($existingIngredient) {
            return response()->json([
                'message' => 'Ingredient already exists!',
                'ingredient' => new IngredientResource($existingIngredient),
            ], 406);
        }

        $ingredient = Ingredient::create([
            'name' => $request->name,
        ]);

        $ingredient->addMediaFromRequest('image')->toMediaCollection('images');

        return new IngredientResource($ingredient);
    }

    public function destroy(string $id)
    {
        $ingredient = Ingredient::find($id);

        if (! $ingredient) {
            return response()->json([
                'message' => 'Ingredient not found!',
            ], 404);
        }

        if (count($ingredient->steps) > 0) {
            return response()->json([
                'message' => 'Ingredient is in use and cannot be deleted!',
            ], 400);
        }

        $ingredient->delete();

        return response()->json([
            'message' => 'Ingredient deleted successfully!',
        ]);
    }
}

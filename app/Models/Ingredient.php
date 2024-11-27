<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ingredient extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['name', 'image'];

    public function steps()
    {
        return $this->belongsToMany(Step::class, 'ingredient_step')
            ->withPivot('amount', 'unit');
    }

    public static function getUnits(): Collection
    {
        return collect(['grams', 'kilograms', 'liters', 'milliliters', 'pounds', 'ounces']);
    }

    public static function getUnitsValueLabel()
    {
        return collect([
            ['value' => 'grams', 'label' => 'Grams'],
            ['value' => 'kilograms', 'label' => 'Kilograms'],
            ['value' => 'liters', 'label' => 'Liters'],
            ['value' => 'milliliters', 'label' => 'Milliliters'],
            ['value' => 'pounds', 'label' => 'Pounds'],
            ['value' => 'ounces', 'label' => 'Ounces'],
        ]);
    }

    public static function getAllIngredientsValueLabel()
    {
        $ingredients = Ingredient::all()->sortBy('name');

        $ingredients = $ingredients->map(function ($ingredient) {
            return ['value' => $ingredient->id, 'label' => $ingredient->name];
        });

        return $ingredients;
    }
}

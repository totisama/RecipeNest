<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Ingredient extends Model
{
    use HasFactory;

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
}

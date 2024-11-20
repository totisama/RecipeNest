<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientStep extends Model
{
    use HasFactory;

    protected $fillable = ['step_id', 'ingredient_id', 'amount'];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}

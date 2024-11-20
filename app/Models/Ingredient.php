<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function steps()
    {
        return $this->belongsToMany(Step::class, 'ingredient_step')
            ->withPivot('amount');
    }
}

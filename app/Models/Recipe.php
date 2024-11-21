<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'total_time', 'description', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function formatTime()
    {
        $hours = floor($this->total_time / 60);
        $minutes = $this->total_time % 60;

        return ($hours > 0 ? $hours.'h ' : '').($minutes > 0 ? $minutes.'m' : '');
    }

    public function getIngredients()
    {
        $ingredients = $this->steps->map(function ($step) {
            return $step->ingredients;
        })->flatten();

        return $ingredients;
    }
}

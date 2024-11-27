<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recipe extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

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

    public function isAuthorized(User $user): void
    {
        $userId = $user->id;

        if (! $userId || $this->user_id != $userId) {
            abort(401);
        }
    }
}

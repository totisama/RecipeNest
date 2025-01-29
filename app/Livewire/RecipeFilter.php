<?php

namespace App\Livewire;

use App\Services\TastyService;
use Livewire\Component;

class RecipeFilter extends Component
{
    public $recipes = [];

    public $query = '';

    protected TastyService $tastyService;

    public function __construct()
    {
        $this->tastyService = new TastyService;
    }

    public function mount(array $recipes)
    {
        $this->recipes = $recipes;
    }

    public function fetchRecipes()
    {
        $query = $this->query;

        $this->recipes = cache()->remember($query, 3600, function () use ($query) {
            return $this->tastyService->filterRecipes($query);
        });
    }

    public function render()
    {
        return view('livewire.recipe-filter');
    }
}

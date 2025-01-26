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
        $this->recipes = $this->tastyService->filterRecipes($this->query);
    }

    public function render()
    {
        return view('livewire.recipe-filter');
    }
}

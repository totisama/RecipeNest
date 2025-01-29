<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteLayout extends Component
{
    public $includeAlpine;

    public function __construct(?bool $noalpine = false)
    {
        $this->includeAlpine = ! $noalpine;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.site.layout');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public $mode;

    /**
     * Create a new component instance.
     */
    public function __construct($mode = 'primary')
    {
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.link');
    }
}

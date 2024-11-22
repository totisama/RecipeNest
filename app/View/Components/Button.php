<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $mode;

    public $type;

    /**
     * Create a new component instance.
     */
    public function __construct($mode = 'primary', $type = 'button')
    {
        $this->mode = $mode;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}

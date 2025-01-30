<?php

namespace App\View\Components\event_wall;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class wall_crate_poll_photo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.event_wall.wall_crate_poll_photo');
    }
}

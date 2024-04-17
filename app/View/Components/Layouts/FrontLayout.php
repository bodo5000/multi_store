<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontLayOut extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $title = 'multi_store')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.front.index');
    }
}

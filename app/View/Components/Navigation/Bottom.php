<?php

namespace App\View\Components\Navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bottom extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.navigation.bottom');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * 
     */
    public function render(): View
    {
        return view('components.admin-layout');
    }
}
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SettingSidebar extends Component
{
    public $pageSelector;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pageSelector)
    {
        $this->pageSelector = $pageSelector;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.setting-sidebar');
    }
}

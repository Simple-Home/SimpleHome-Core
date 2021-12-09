<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertComponent extends Component
{
    /**
     * The priority of the alert, i.e., "info", or "warning"
     *
     * @var string
     */
    public $level;

    /**
     * The message or an array of messages to present to the user
     *
     * @var mixed
     */
    public $message;

    /**
     * Create a new component instance.
     *
     * @param  string  $level
     * @param  mixed   $message
     */
    public function __construct(string $level, $message)
    {
        $this->level   = $level;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        return view('components.alert-component');
    }
}

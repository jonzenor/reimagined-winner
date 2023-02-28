<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LabeledInput extends Component
{
    public $name;
    public $label;
    public $placeholder;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $placeholder = "", $value = "")
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.labeled-input');
    }
}

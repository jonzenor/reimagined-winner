<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectDropdown extends Component
{
    public $name;
    public $options;
    public $label;
    public $selected;
    public $first;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $options, $label = "", $selected = "", $firstOption = "")
    {
        $this->name = $name;
        $this->options = $options;
        $this->label = $label;
        $this->selected = $selected;
        $this->first = $firstOption;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select-dropdown');
    }
}

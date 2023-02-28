<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageButtons extends Component
{
    public $primaryLink;
    public $primaryText;
    public $secondaryLink;
    public $secondaryText;

    /**
     * Create a new component instance.
     */
    public function __construct($primaryLink = "", $primaryText = "", $secondaryLink = "", $secondaryText = "")
    {
        $this->primaryLink = $primaryLink;
        $this->secondaryLink = $secondaryLink;
        $this->primaryText = $primaryText;
        $this->secondaryText = $secondaryText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-buttons');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $style;
    public $icon;
    public $text;

    public function render()
    {
        return view('livewire.button');
    }
}

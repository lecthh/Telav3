<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardCard extends Component
{
    public $svg;
    public $heading;
    public $value;

    public function mount($svg, $heading, $value)
    {
        $this->svg = $svg;
        $this->heading = $heading;
        $this->value = $value;
    }
    
    public function render()
    {
        return view('livewire.dashboard-card');
    }
}

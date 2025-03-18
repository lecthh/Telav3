<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardCard extends Component
{
    public $svg;
    public $heading;
    public $value;
    public $route;

    public function mount($svg, $heading, $value, $route = null)
    {
        $this->svg = $svg;
        $this->heading = $heading;
        $this->value = $value;
        $this->route = $route;
    }
    
    public function render()
    {
        return view('livewire.dashboard-card');
    }
}

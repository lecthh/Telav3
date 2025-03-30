<?php

namespace App\Livewire;

use App\Models\Designer;
use Livewire\Component;

class DesignerDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;

    protected function getListeners()
    {
        return [
            'showDesignerDetails' => 'showDetails',
        ];
    }

    public function showDetails($id)
    {
        $this->selectedItem = Designer::find($id);
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.designer-details-modal');
    }
}

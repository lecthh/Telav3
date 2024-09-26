<?php

namespace App\Livewire;

use Livewire\Component;

class OrderBulkCustomized extends Component
{
    public $rows = [];
    public function mount(){
        $this->rows = [
            ['name' => '', 'size' => '', 'remarks' => '']
        ];
    }

    public function addRow(){
        $this->rows[] = ['name' => '', 'size' => '', 'remarks' => ''];
    }
    public function deleteRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows); // Re-index the array
    }

    public function render()
    {
        return view('livewire.order-bulk-customized');
    }
}

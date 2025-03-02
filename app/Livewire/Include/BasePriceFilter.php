<?php

namespace App\Livewire\Include;

use Livewire\Component;

class BasePriceFilter extends Component
{
    public $basePrice = null;
    public $options = [
        ['value' => null, 'label' => 'All Prices'],
        ['value' => 100, 'label' => 'Under $100'],
        ['value' => 500, 'label' => 'Under $500'],
        ['value' => 1000, 'label' => 'Under $1,000'],
        ['value' => 2000, 'label' => 'Under $2,000'],
    ];

    public function updatedBasePrice()
    {
        $this->emit('filterByBasePrice', $this->basePrice);
    }

    public function render()
    {
        return view('livewire.include.base-price-filter');
    }
}
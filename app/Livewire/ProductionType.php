<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\ProductionType as ProductionTypeModel;

class ProductionType extends Component
{
    #[Rule('required')]
    public $name;

    public $productionTypes;

    public function create () {
        ProductionTypeModel::create([
            'name' => $this->name,
            'img' => $this->img,
        ]);
    }

    public function mount() {
        $this->productionTypes = ProductionTypeModel::all();
    }

    public function render()
    {
        return view('livewire.production-type', [
            'productionTypes' => $this->productionTypes,
        ]);
    }
}

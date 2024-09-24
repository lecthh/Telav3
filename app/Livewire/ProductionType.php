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
    public $selectedProductionType;
    public $apparel;

    public function create()
    {
        ProductionTypeModel::create([
            'name' => $this->name,
            'img' => $this->img,
        ]);
    }

    public function mount($apparel)
    {
        $this->apparel = $apparel;
        $this->productionTypes = ProductionTypeModel::all();
    }
    public function selectProductionType($productionTypeId)
    {
        $this->selectedProductionType = $productionTypeId;
    }

    public function submit()
    {
        if ($this->selectedProductionType) {
            return redirect()->route('customer.place-order.select-production-company', [
                'productionType' => $this->selectedProductionType,
                'apparel' => $this->apparel
            ]);
        } else {
            session()->flash('error', 'Please select a production type');
        }
    }
    public function back()
    {
        return redirect()->route('customer.place-order.select-apparel');
    }

    public function render()
    {
        return view('livewire.production-type', [
            'productionTypes' => $this->productionTypes,
        ]);
    }
}

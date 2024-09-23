<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ApparelType as ApparelTypeModel;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class ApparelType extends Component
{
    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $img;

    public $apparelTypes;
    public $selectedApparelType;
    public $currentStep = 1;

    public function create()
    {
        ApparelTypeModel::create([
            'name' => $this->name,
            'img' => $this->img,
        ]);
    }

    public function mount()
    {
        $this->apparelTypes = ApparelTypeModel::all();
        $this->selectedApparelType = null;
    }

    public function selectApparelType($apparelTypeId)
    {
        $this->selectedApparelType = $apparelTypeId;
    }

    public function submit()
    {
        if ($this->selectedApparelType) {
            return redirect()->route('customer.place-order.select-production-type', ['apparel' => $this->selectedApparelType]);
        } else {
            session()->flash('error', 'Please select an apparel type');
        }
    }

    public function render()
    {
        return view('livewire.apparel-type', [
            'apparelTypes' => $this->apparelTypes,
            'currentStep' => $this->currentStep,
        ]);
    }
}

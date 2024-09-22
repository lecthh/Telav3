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
    
    public function create() {
        ApparelTypeModel::create([
            'name' => $this->name,
            'img' => $this->img,
        ]);
    }

    public function mount() {
        $this->apparelTypes = ApparelTypeModel::all();
    }

    public function render()
    {
        return view('livewire.apparel-type', [
            'apparelTypes' => $this->apparelTypes,
        ]);
    }
}

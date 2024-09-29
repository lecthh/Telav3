<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProducCompProfileUpdate extends Component
{
    public $company_name;
    public $company_email;
    public $phone;
    public $address;

    public function mount(){
        $user = Auth::user();
        $this->company_name = $user->company_name;
        $this->company_email = $user->company_email;
    }

    public function render()
    {
        return view('livewire.produc-comp-profile-update');
    }
}

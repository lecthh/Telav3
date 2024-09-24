<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateProfile extends Component
{
    public $name;
    public $email;

    public function mount() {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save() {
        $user = Auth::user();

        $validatedData = Validator::make([
            'name' => $this->name,
            'email' => $this->email,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'nullable|string|max:15',
        ])->validate();

        $user->fill($validatedData);
        $user->save();

        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.update-profile');
    }
}

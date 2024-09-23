<?php

namespace App\Livewire;

use App\Models\ApparelType;
use App\Models\ProductionCompany;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ProducerRegistration extends Component
{
    #[Rule('required', 'array')]
    public array $production_type;

    #[Rule('required', 'array')]
    public array $apparel_type;

    #[Rule('required', 'string')]
    public string $company_name;

    #[Rule('required', 'email')]
    public string $email;

    #[Rule('required')]
    public string $mobile;

    #[Rule('required')]
    public string $address;

    #[Rule('required')]
    public string $state;

    #[Rule('required')]
    public string $city;

    #[Rule('required')]
    public string $zip_code;

    public $apparelTypes;

    public function submit()
    {
        $validatedData = $this->validate();
        $address = $validatedData['address'] . ', ' . $validatedData['city'] . ', ' . $validatedData['state'] . ', ' . $validatedData['zip_code'];
        ProductionCompany::create([
            'production_type' => json_encode($validatedData['production_type']),
            'apparel_type' => json_encode($validatedData['apparel_type']),
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['mobile'],
            'address' => $address,
            'avg_rating' => 0,
            'review_count' => 0,
        ]);

        session()->flash('message', 'Producer registration successful!');
        redirect()->route('partner-confirmation');
    }


    public function mount()
    {
        $this->apparelTypes = ApparelType::all();
    }

    public function render()
    {
        return view('livewire.producer-registration', ['apparelTypes' => $this->apparelTypes]);
    }
}

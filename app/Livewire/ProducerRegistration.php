<?php

namespace App\Livewire;

use App\Models\AddressInformation;
use App\Models\ApparelType;
use App\Models\ProductionCompany;
use App\Models\ProductionCompanyPricing;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ProducerRegistration extends Component
{
    public array $production_type;
    public array $apparel_type;
    public string $company_name;
    public string $email;
    public string $mobile;
    public string $address;
    public string $state;
    public string $city;
    public string $zip_code;
    public $apparelTypes;

    public function submit()
    {
        $validatedData = $this->validate([
            'production_type' => 'required|array',
            'apparel_type' => 'required|array',
            'company_name' => 'required|string|unique:production_companies,company_name',
            'email' => 'required|email|unique:production_companies,email|unique:users,email',
            'mobile' => 'required|string|unique:production_companies,phone',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        $address = $validatedData['address'] . ', ' . $validatedData['city'] . ', ' . $validatedData['state'] . ', ' . $validatedData['zip_code'];

        // Create User
        $user = User::create([
            'user_id' => uniqid(),
            'name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
            'role_type_id' => 2,
        ]);

        // Create Address Information
        AddressInformation::create([
            'user_id' => $user->user_id,
            'address' => $validatedData['address'],
            'state' => $validatedData['state'],
            'city' => $validatedData['city'],
            'zip_code' => $validatedData['zip_code'],
            'phone_number' => $validatedData['mobile'],
        ]);

        // Create Production Company
        $productionCompany = ProductionCompany::create([
            'production_type' => json_encode($validatedData['production_type']),
            'apparel_type' => json_encode($validatedData['apparel_type']),
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['mobile'],
            'address' => $address,
            'avg_rating' => 0,
            'company_logo' => 'imgs/companyLogo/placeholder.jpg',
            'review_count' => 0,
            'user_id' => $user->user_id,
        ]);

        // Create Production Company Pricing
        foreach ($validatedData['production_type'] as $productionType) {
            foreach ($validatedData['apparel_type'] as $apparelType) {
                ProductionCompanyPricing::create([
                    'production_company_id' => $productionCompany->id,
                    'production_type' => $productionType,
                    'apparel_type' => $apparelType,
                    'base_price' => 0.00,
                    'bulk_price' => 0.00,
                ]);
            }
        }

        // Generate Token and Send Email
        $token = uniqid();
        $url = URL::temporarySignedRoute(
            'set-password',
            now()->addMinutes(60),
            ['token' => $token, 'email' => $user->email]
        );
        $name = $user->name;

        $user->update(['passwordToken' => $token]);
        $user->save();

        Mail::send('mail.verify', ['url' => $url, 'name' => $name], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Set Your Password');
        });

        // Redirect to Confirmation Page
        return redirect()->route('partner-confirmation');
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
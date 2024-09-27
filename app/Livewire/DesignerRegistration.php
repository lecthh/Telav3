<?php

namespace App\Livewire;

use App\Models\Designer;
use Livewire\Component;
use App\Models\ProductionCompany;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class DesignerRegistration extends Component
{
    public $affiliated_producer;
    public $display_name;
    public $first_name;
    public $last_name;
    public $email;
    public $productionCompanies;
    public $affiliate;

    public function mount()
    {
        $this->productionCompanies = ProductionCompany::all();
        $this->affiliate = 'yes';
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'affiliate' => 'required|string',
            'affiliated_producer' => 'required_if:affiliate,yes|string',
            'display_name' => 'required_if:affiliate,no|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);


        $fullname = $validatedData['first_name'] . ' ' . $validatedData['last_name'];


        $user = User::create([
            'user_id' => uniqid(),
            'name' => $fullname,
            'email' => $validatedData['email'],
            'role_type_id' => 3,
        ]);

        $isFreelancer = $validatedData['affiliate'] === 'no';

        Designer::create([
            'user_id' => $user->user_id,
            'is_freelancer' => $isFreelancer,
            'production_company_id' => $isFreelancer ? null : $validatedData['affiliated_producer'],
            'designer_description' => $isFreelancer ? $validatedData['display_name'] : null,
            'talent_fee' => 0,
            'max_free_revisions' => 3,
            'addtl_revision_fee' => 50.00,
            'order_history' => json_encode([]),
            'average_rating' => 0,
            'review_count' => 0,
        ]);

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
        redirect()->route('partner-confirmation');
    }

    public function render()
    {
        return view('livewire.designer-registration');
    }
}

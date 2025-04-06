<?php

namespace App\Livewire;

use App\Models\AddressInformation;
use App\Models\ApparelType;
use App\Models\BusinessDocument;
use App\Models\ProductionCompany;
use App\Models\ProductionCompanyPricing;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;


class ProducerRegistration extends Component
{
    use WithFileUploads;

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

    // New property to store document entries
    public $documents = [];

    public function mount()
    {
        $this->apparelTypes = ApparelType::all();
        // Start with one empty document entry
        $this->documents = [
            ['name' => '', 'file' => null],
        ];
    }

    public function addDocument()
    {
        $this->documents[] = ['name' => '', 'file' => null];
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'production_type'      => 'required|array',
            'apparel_type'         => 'required|array',
            'company_name'         => 'required|string|unique:production_companies,company_name',
            'email'                => 'required|email|unique:production_companies,email|unique:users,email',
            'mobile'               => 'required|string|unique:production_companies,phone',
            'address'              => 'required|string',
            'state'                => 'required|string',
            'city'                 => 'required|string',
            'zip_code'             => 'required|string',
            'documents.*.name'     => 'required|string',
            'documents.*.file'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5048',
        ], [
            'documents.*.name.required' => 'Please provide a name for the document.',
            'documents.*.file.required' => 'Please upload a document.',
            'documents.*.file.mimes'    => 'Accepted document formats are PDF, JPG, JPEG, PNG.',
            'documents.*.file.max'      => 'The document may not be greater than 5 MB.',
            'documents.*.file.uploaded' => 'The document may not be greater than 5 MB.',
        ], [
            'documents.*.name' => 'document name',
            'documents.*.file' => 'document file',
        ]);


        $fullAddress = $validatedData['address'] . ', ' . $validatedData['city'] . ', ' . $validatedData['state'] . ', ' . $validatedData['zip_code'];

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
            'address' => $fullAddress,
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

        // Process each business document entry
        foreach ($this->documents as $document) {
            $documentPath = $document['file']->store('business_documents', 'public');

            BusinessDocument::create([
                'production_company_id' => $productionCompany->id,
                'name' => $document['name'],
                'path' => $documentPath,
            ]);
        }

        // Generate token and send email for setting password


        // Redirect to Confirmation Page
        return redirect()->route('partner-confirmation');
    }

    public function render()
    {
        return view('livewire.producer-registration', ['apparelTypes' => $this->apparelTypes]);
    }
}

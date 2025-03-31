<?php

namespace App\Livewire;

use App\Traits\Toastable;
use Livewire\Component;

class ProductionCompanyEditModal extends Component
{
    use Toastable;
    public $showEditModal = false;
    public $selectedItem = null;

    protected $listeners = [
        'editCompany' => 'editProductionCompanyDetails',
    ];

    public function editProductionCompanyDetails($companyId)
    {
        $company = \App\Models\ProductionCompany::find($companyId);
        if ($company) {
            // Convert the model to an array for binding with the form inputs.
            $this->selectedItem = $company->toArray();
            $this->showEditModal = true;
        }
    }

    public function saveProductionCompany()
    {
        $company = \App\Models\ProductionCompany::find($this->selectedItem['id']);

        if (!$company) {
            session()->flash('error', 'Production company not found.');
            return;
        }

        $company->company_name = $this->selectedItem['company_name'];
        $company->address      = $this->selectedItem['address'];
        $company->phone        = $this->selectedItem['phone'];
        $company->email        = $this->selectedItem['email'];
        $company->user_id      = $this->selectedItem['user_id'];
        $company->save();

        $this->showEditModal = false;
        $this->dispatch('toast', [
            'message' => 'Production Company updated successfully.',
            'type' => 'success'
        ]);
        $this->dispatch('refreshTable');
        session()->flash('message', 'Production company updated successfully.');
    }


    public function render()
    {
        return view('livewire.production-company-edit-modal');
    }
}

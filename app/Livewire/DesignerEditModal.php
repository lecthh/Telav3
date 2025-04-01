<?php

namespace App\Livewire;

use App\Models\Designer;
use App\Traits\Toastable;
use Livewire\Component;

class DesignerEditModal extends Component
{

    use Toastable;

    public $showEditModal = false;
    public $selectedItem = null;

    protected $listeners = [
        'editDesigner' => 'editDesignerDetails',
    ];

    public function editDesignerDetails($designerId)
    {
        $designer = Designer::find($designerId);
        if ($designer) {

            // Convert the model to an array for binding with the form inputs.
            $this->selectedItem = $designer->toArray();
            $this->selectedItem['user_name'] = $designer->user_name;
            $this->selectedItem['production_company_name'] = $designer->production_company_name;
            $this->showEditModal = true;
        }
    }

    public function updateDesigner()
    {
        $designer = \App\Models\Designer::find($this->selectedItem['designer_id']);
        if (!$designer) {
            session()->flash('error', 'Designer not found.');
            return;
        }

        // Update designer-specific fields
        $designer->is_freelancer       = $this->selectedItem['is_freelancer'];
        $designer->is_available        = $this->selectedItem['is_available'];
        $designer->talent_fee          = $this->selectedItem['talent_fee'];
        $designer->max_free_revisions  = $this->selectedItem['max_free_revisions'];
        $designer->addtl_revision_fee  = $this->selectedItem['addtl_revision_fee'];
        $designer->designer_description = $this->selectedItem['designer_description'];

        // Also update the associated user's name
        if ($designer->user) {
            $designer->user->name = $this->selectedItem['user_name'];
            $designer->user->save();
        }

        $designer->save();

        $this->showEditModal = false;
        $this->dispatch('toast', [
            'message' => 'Designer updated successfully.',
            'type'    => 'success'
        ]);
        $this->dispatch('refreshTable');
        session()->flash('message', 'Designer updated successfully.');
    }


    public function render()
    {
        return view('livewire.designer-edit-modal');
    }
}

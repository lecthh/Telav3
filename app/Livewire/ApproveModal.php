<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ApproveModal extends Component
{
    public $showApproveModal = false;
    public $selectedItems = [];
    public $displayNames = [];  
    public $entityType = '';
    public $primaryKey = 'id';

    protected function getListeners()
    {
        return ['approveEntity' => 'showApproveModal'];
    }

    public function showApproveModal($modelClass, $ids, $displayColumn = 'name', $primaryKey)
    {
        // Ensure $ids is an array
        $ids = is_array($ids) ? $ids : [$ids];

        // Retrieve all selected items using the provided primary key
        $this->selectedItems = $modelClass::whereIn($primaryKey, $ids)->get();

        $this->entityType = class_basename($modelClass);

        // Gather the display names from the specified column
        $this->displayNames = collect($this->selectedItems)->pluck($displayColumn)
            ->filter()
            ->all();

        $this->showApproveModal = true;
    }

    public function approveConfirmed()
    {
        try {
            if (empty($this->selectedItems)) {
                Log::error('No items selected for approval');
                $this->dispatch('approve-error', 'No items selected for approval');
                return;
            }

            // Capture names and count before approval
            $names = implode(', ', $this->displayNames);
            $count = count($this->displayNames);

            // Update each item to set is_verified to true
            foreach ($this->selectedItems as $item) {
                $item->update(['is_verified' => true]);
            }

            Log::info("Approved {$this->entityType}(s): {$names}");

            $this->showApproveModal = false;
            $this->selectedItems = [];
            $this->displayNames = [];

            $message = $count > 1
                ? "{$this->entityType}s approved successfully"
                : "{$names} approved successfully";

            $this->dispatch('itemApproved');
            $this->dispatch('toast', [
                'message' => $message,
                'type' => 'success'
            ]);
            $this->dispatch('refreshTable');
        } catch (\Exception $e) {
            Log::error("Error approving {$this->entityType}: " . $e->getMessage());
            $this->dispatch('approve-error', "Failed to approve {$this->entityType}: " . $e->getMessage());
        }
    }

    public function cancelApprove()
    {
        $this->showApproveModal = false;
        $this->selectedItems = [];
        $this->displayNames = [];
    }

    public function render()
    {
        return view('livewire.approve-modal');
    }
}

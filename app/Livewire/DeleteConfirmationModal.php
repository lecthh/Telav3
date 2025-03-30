<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeleteConfirmationModal extends Component
{
    public $showDeleteModal = false;
    public $selectedItems = []; // Now supports multiple items
    public $displayNames = [];  // Array of display names for each item
    public $entityType = '';
    public $primaryKey = 'id';


    protected function getListeners()
    {
        return ['deleteEntity' => 'showDeleteModal'];
    }

    public function showDeleteModal($modelClass, $ids, $displayColumn = 'name', $primarykey)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        $this->selectedItems = $modelClass::whereIn($primarykey, $ids)->get();

        $this->entityType = class_basename($modelClass);

        $this->displayNames = collect($this->selectedItems)->pluck($displayColumn)
            ->filter()
            ->all();

        $this->showDeleteModal = true;
    }

    public function deleteConfirmed()
    {
        try {
            if (empty($this->selectedItems)) {
                Log::error('No items selected for deletion');
                $this->dispatch('delete-error', 'No items selected for deletion');
                return;
            }

            // Capture names and count before deletion
            $names = implode(', ', $this->displayNames);
            $count = count($this->displayNames);

            // Delete each item
            foreach ($this->selectedItems as $item) {
                $item->delete();
            }

            Log::info("Deleted {$this->entityType}(s): {$names}");

            $this->showDeleteModal = false;
            $this->selectedItems = [];
            $this->displayNames = [];

            // Build a suitable success message
            $message = $count > 1
                ? "{$this->entityType}s deleted successfully"
                : "{$names} deleted successfully";

            $this->dispatch('itemDeleted');
            $this->dispatch('toast', [
                'message' => $message,
                'type' => 'success'
            ]);
            $this->dispatch('refreshTable');
        } catch (\Exception $e) {
            Log::error("Error deleting {$this->entityType}: " . $e->getMessage());
            $this->dispatch('delete-error', "Failed to delete {$this->entityType}: " . $e->getMessage());
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->selectedItems = [];
        $this->displayNames = [];
    }

    public function render()
    {
        return view('livewire.delete-confirmation-modal');
    }
}


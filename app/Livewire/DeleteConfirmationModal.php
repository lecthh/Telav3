<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeleteConfirmationModal extends Component
{
    public $showDeleteModal = false;
    public $selectedItem = null;
    public $displayName = '';
    public $entityType = '';

    protected function getListeners()
    {
        return ['deleteEntity' => 'showDeleteModal'];
    }

    public function showDeleteModal($modelClass, $id, $displayColumn = 'name')
    {
        $this->selectedItem = $modelClass::find($id);
        
        // Determine the entity type (e.g., "User", "Post") from the model class
        $this->entityType = class_basename($modelClass);
        
        // Retrieve the display name from the specified column
        $this->displayName = $this->selectedItem->$displayColumn ?? '';
 
        $this->showDeleteModal = true;
    }

    public function deleteConfirmed()
    {
        try {
            // Ensure an item is selected
            if (!$this->selectedItem) {
                Log::error('No item selected for deletion');
                $this->dispatch('delete-error', 'No item selected for deletion');
                return;
            }

            // Perform the deletion
            $this->selectedItem->delete();

            // Log the deletion
            Log::info("Deleted {$this->entityType}: {$this->displayName}");

            // Reset modal state
            $this->showDeleteModal = false;
            $this->selectedItem = null;

            // Dispatch events to update the parent component
            $this->dispatch('item-deleted', $this->entityType);
            $this->dispatch('toast', [
                'message' => "{$this->entityType} '{$this->displayName}' deleted successfully",
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error deleting {$this->entityType}: " . $e->getMessage());

            // Dispatch error event
            $this->dispatch('delete-error', "Failed to delete {$this->entityType}: " . $e->getMessage());
        }
    }

    public function cancelDelete()
    {
        // Reset modal state
        $this->showDeleteModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        return view('livewire.delete-confirmation-modal');
    }
}
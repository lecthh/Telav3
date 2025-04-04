<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Mail\BlockedEntityMail;
use App\Mail\DeniedEntityMail;

class DeleteConfirmationModal extends Component
{
    public $showDeleteModal = false;
    public $selectedItems = [];
    public $displayNames = [];
    public $entityType = '';
    public $primaryKey = 'id';
    public $reason = '';
    public $selectedCommonReasons = [];
    public $actionType = '';

    protected function getListeners()
    {
        return ['deleteEntity' => 'showDeleteModal'];
    }

    /**
     * Now accepts a type ($type) so the modal knows whether it is in approve (deny-only)
     * or manage (block & deny) mode.
     */
    public function showDeleteModal($modelClass, $ids, $type, $displayColumn = 'name', $primarykey)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        $this->selectedItems = $modelClass::whereIn($primarykey, $ids)->get();
        $this->entityType = class_basename($modelClass);
        $this->displayNames = collect($this->selectedItems)->pluck($displayColumn)
            ->filter()
            ->all();

        // Clear any previous reason and selected checkboxes
        $this->reason = '';
        $this->selectedCommonReasons = [];
        $this->actionType = $type;

        $this->showDeleteModal = true;
    }

    /**
     * Helper to compose the final reason from the custom input and selected common reasons.
     */
    protected function composeFinalReason()
    {
        $customReason = trim($this->reason);
        $html = '';

        if (!empty($this->selectedCommonReasons)) {
            $html .= '<ul>';
            foreach ($this->selectedCommonReasons as $common) {
                $html .= '<li>' . e($common) . '</li>';
            }
            $html .= '</ul>';
        }

        if (!empty($customReason)) {
            $html .= '<p>' . e($customReason) . '</p>';
        }

        return $html;
    }

    /**
     * Block action: update status to blocked and email the reason.
     */
    public function blockConfirmed()
    {
        try {
            if (empty($this->selectedItems)) {
                Log::error('No items selected for blocking');
                $this->dispatch('action-error', 'No items selected for blocking');
                return;
            }

            $finalReason = $this->composeFinalReason();

            foreach ($this->selectedItems as $item) {
                $name = $item->company_name ?? $item->name;
                $item->status = 'blocked';
                $item->save();
                $item->refresh();
                Mail::to($item->email)->queue(new BlockedEntityMail($name, $finalReason));
            }

            $names = implode(', ', $this->displayNames);
            Log::info("Blocked {$this->entityType}(s): {$names}");

            $message = count($this->displayNames) > 1
                ? "{$this->entityType}s blocked successfully"
                : "{$names} blocked successfully";

            $this->dispatch('itemBlocked');
            $this->dispatch('toast', [
                'message' => $message,
                'type' => 'success'
            ]);

            $this->dispatch('refreshTable');
            $this->resetModal();
        } catch (\Exception $e) {
            Log::error("Error blocking {$this->entityType}: " . $e->getMessage());
            $this->dispatch('action-error', "Failed to block {$this->entityType}: " . $e->getMessage());
        }
    }

    /**
     * Deny action: delete the item(s) and email the reason.
     */
    public function denyConfirmed()
    {
        try {
            if (empty($this->selectedItems)) {
                Log::error('No items selected for denial');
                $this->dispatch('action-error', 'No items selected for denial');
                return;
            }

            $finalReason = $this->composeFinalReason();
            Log::info("Final reason for Denying: {$finalReason}");
            foreach ($this->selectedItems as $item) {
                // Load the associated user before deleting the item.
                $associatedUser = $item->user;

                $name = $associatedUser->name;
                Log::info("Processing item for denial", [
                    'item_id' => $item->id,
                    'email' => $item->email,
                    'name' => $name,
                ]);
                Mail::to($item->email)->queue(new DeniedEntityMail($name, $finalReason));

                // Delete the entity.
                $item->delete();

                // If there's an associated user, delete it as well.
                if ($associatedUser) {
                    $associatedUser->delete();
                }
            }

            $names = implode(', ', $this->displayNames);
            Log::info("Denied {$this->entityType}(s): {$names}");

            $message = count($this->displayNames) > 1
                ? "{$this->entityType}s denied successfully"
                : "{$names} denied successfully";

            $this->dispatch('itemDenied');
            $this->dispatch('toast', [
                'message' => $message,
                'type' => 'success'
            ]);
            $this->dispatch('refreshTable');
            $this->resetModal();
        } catch (\Exception $e) {
            Log::error("Error denying {$this->entityType}: " . $e->getMessage());
            $this->dispatch('action-error', "Failed to deny {$this->entityType}: " . $e->getMessage());
        }
    }


    public function cancelDelete()
    {
        $this->resetModal();
    }

    protected function resetModal()
    {
        $this->showDeleteModal = false;
        $this->selectedItems = [];
        $this->displayNames = [];
        $this->reason = '';
        $this->selectedCommonReasons = [];
        $this->actionType = '';
    }

    public function render()
    {
        return view('livewire.delete-confirmation-modal');
    }
}

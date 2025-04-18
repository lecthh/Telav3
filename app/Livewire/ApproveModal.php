<?php

namespace App\Livewire;

use App\Mail\ReactivatedEntityMail;
use App\Mail\SetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Reactive;

class ApproveModal extends Component
{
    public $showApproveModal = false;
    public $selectedItems = [];
    public $displayNames = [];
    public $entityType = '';
    public $primaryKey = 'id';
    public $type; // 'approve' or 'reactivate'

    protected function getListeners()
    {
        return ['approveEntity' => 'showApproveModal'];
    }

    /**
     * Now accepts a $type parameter which should be either 'approve' or 'reactivate'.
     */
    public function showApproveModal($modelClass, $ids, $type, $displayColumn = 'name', $primaryKey)
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

        $this->type = $type;
        $this->showApproveModal = true;
    }

    /**
     * Approve action: sets is_verified to true, updates status to active,
     * sends a password setup email, and marks the user's email as verified.
     */
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

            // Update each item to set is_verified to true and status to active
            foreach ($this->selectedItems as $item) {
                $item->update(['is_verified' => true, 'status' => 'active']);
            }

            Log::info("Approved {$this->entityType}(s): {$names}");

            // Process each item for password setup
            foreach ($this->selectedItems as $item) {
                Log::info('Processing item for password setup', [
                    'production_company_id' => $item->id,
                    'email' => $item->email,
                    'name' => $item->company_name,
                ]);

                $token = uniqid();
                Log::info('Generated token', ['token' => $token]);

                $url = URL::temporarySignedRoute(
                    'set-password',
                    now()->addMinutes(60),
                    ['token' => $token, 'email' => $item->email]
                );
                Log::info('Generated temporary signed URL', ['url' => $url]);

                $name = $item->company_name;
                $updateResult = $item->user->update(['passwordToken' => $token]);
                Log::info('User updated with password token', [
                    'user_id' => $item->user->user_id,
                    'update_result' => $updateResult,
                ]);
                User::where('user_id', $item->user->user_id)
                    ->update(['email_verified_at' => now()]);

                Mail::to($item->email)->queue(new SetPasswordMail($url, $name));
                Log::info('Queued password setup email', ['email' => $item->email]);
            }

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

    /**
     * Reactivate action: changes the status from blocked to active.
     */
    public function reactivateConfirmed()
    {
        try {
            if (empty($this->selectedItems)) {
                Log::error('No items selected for reactivation');
                $this->dispatch('approve-error', 'No items selected for reactivation');
                return;
            }

            $names = implode(', ', $this->displayNames);
            $count = count($this->displayNames);

            foreach ($this->selectedItems as $item) {
                // Set status to active
                $item->update(['status' => 'active']);


                $revertedOrders = $item->orders()
                    ->where('status_id', 9)
                    ->whereNotNull('previous_status')
                    ->get();

                foreach ($revertedOrders as $order) {
                    $order->status_id = $order->previous_status;
                    $order->previous_status = null;
                    $order->save();
                }

                $name = $item->company_name ?? $item->name;

                Log::info('Reactivating item', [
                    'item_id' => $item->id,
                    'email' => $item->email,
                    'name' => $name,
                ]);

                Mail::to($item->email)->queue(new ReactivatedEntityMail($name));
            }

            Log::info("Reactivated {$this->entityType}(s): {$names}");

            $this->showApproveModal = false;
            $this->selectedItems = [];
            $this->displayNames = [];

            $message = $count > 1
                ? "{$this->entityType}s reactivated successfully"
                : "{$names} reactivated successfully";

            $this->dispatch('itemApproved');
            $this->dispatch('toast', [
                'message' => $message,
                'type' => 'success'
            ]);
            $this->dispatch('refreshTable');
        } catch (\Exception $e) {
            Log::error("Error reactivating {$this->entityType}: " . $e->getMessage());
            $this->dispatch('approve-error', "Failed to reactivate {$this->entityType}: " . $e->getMessage());
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

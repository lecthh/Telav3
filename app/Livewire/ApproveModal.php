<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

                Mail::send('mail.verify', ['url' => $url, 'name' => $name], function ($message) use ($item) {
                    $message->to($item->email);
                    $message->subject('Set Your Password');
                });
                Log::info('Sent password setup email', ['email' => $item->email]);
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

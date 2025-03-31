<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class EditUserDetailsModal extends Component
{
    use WithFileUploads;

    public $showEditModal = false;
    public $selectedItem = null;
    public $avatarFile;
    public $avatarPath;

    protected $listeners = [
        'editUser' => 'editUserDetails',
    ];

    public function editUserDetails($userId)
    {
        $user = \App\Models\User::find($userId);
        if ($user) {
            // Convert the model to an array for proper binding
            $this->selectedItem = $user->toArray();
            $this->showEditModal = true;
        }
    }

    public function updatedAvatarFile()
    {
        $this->validate([
            'avatarFile' => 'image|max:1024',
        ]);

        // Optional: Store the file temporarily
        $this->avatarPath = $this->avatarFile->store('avatars', 'public');
    }

    public function updateUser()
    {
        // Retrieve the user model based on the ID from the selected array.
        $user = \App\Models\User::find($this->selectedItem['user_id']);

        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        // If a new avatar is uploaded, handle the file upload.
        if ($this->avatarFile) {
            $avatarPath = $this->avatarFile->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->name  = $this->selectedItem['name'];
        $user->email = $this->selectedItem['email'];
        $user->save();

        $this->showEditModal = false;
        $this->dispatch('refreshUsersTable');
        $this->dispatch('toast', [
            'message' => 'User updated successfully.',
            'type' => 'success'
        ]);
    }


    public function render()
    {
        return view('livewire.edit-user-details-modal');
    }
}

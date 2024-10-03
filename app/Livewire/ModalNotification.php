<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalNotification extends Component
{
    public $notifications;
    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->notifications = Notification::with('user')
                ->where('user_id', $user->user_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->notifications = collect();
        }
    }

    public function render()
    {
        return view('livewire.modal-notification');
    }
}

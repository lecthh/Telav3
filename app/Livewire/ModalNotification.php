<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalNotification extends Component
{
    public $notifications;
    public $filter = 'all';
    
    public function mount()
    {
        $this->loadNotifications();
    }
    
    public function loadNotifications()
    {
        $user = Auth::user();
        if ($user) {
            $query = Notification::with('user')
                ->where('user_id', $user->user_id)
                ->orderBy('created_at', 'desc');
                
            if ($this->filter === 'unread') {
                $query->where('is_read', false);
            }
            
            $this->notifications = $query->get();
        } else {
            $this->notifications = collect();
        }
    }
    
    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->loadNotifications();
    }
    
    public function markAsRead($notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            
            if ($notification && !$notification->is_read) {
                $notification->is_read = true;
                $notification->save();
                $this->dispatch('notificationStatusChanged');
            }
            $this->loadNotifications();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error marking notification as read: ' . $e->getMessage());
        }
    }
    
    public function markAllAsRead()
    {
        $user = Auth::user();
        if ($user) {
            Notification::where('user_id', $user->user_id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            $this->dispatch('notificationStatusChanged');
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.modal-notification');
    }
}

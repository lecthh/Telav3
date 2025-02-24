<?php

namespace App\Traits;

trait Toastable
{
    /**
     * Flash a toast message to the session.
     *
     * @param string $message
     * @param string $type    // e.g., 'success', 'error', 'info', etc.
     */
    public function toast(string $message, string $type = 'success')
    {
        session()->flash('toast', [
            'message' => $message,
            'type'    => $type,
        ]);
    }
}

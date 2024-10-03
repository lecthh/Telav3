<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
        'order_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }
    public function markAsUnread()
    {
        $this->is_read = false;
        $this->save();
    }
    public function orders(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}

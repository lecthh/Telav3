<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'image',
        'status_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderImageStatus::class, 'status_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceReceipt extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'amount',
        'receipt_image_path',
        'notes'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}

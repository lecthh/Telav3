<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizationDetails extends Model
{
    use HasFactory;
    protected $table = 'customization_details';
    protected $primaryKey = 'customization_details_ID';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'customization_details_ID',
        'remarks',
        'sizes_ID',
        'name',
        'jersey_number',
        'short_number',
        'short_size',
        'quantity',
        'order_ID',
        'has_pocket'
    ];

    public function size()
    {
        return $this->belongsTo(Sizes::class, 'sizes_ID', 'sizes_ID');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_ID', 'order_ID');
    }
}

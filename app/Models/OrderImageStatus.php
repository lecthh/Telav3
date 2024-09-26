<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImageStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function orderImages()
    {
        return $this->hasMany(OrderImages::class, 'status_id');
    }
}

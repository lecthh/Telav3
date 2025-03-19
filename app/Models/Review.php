<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'user_id',
        'production_company_id',
        'designer_id',
        'rating',
        'comment',
        'is_visible',
        'review_type'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id');
    }

    public function designer()
    {
        return $this->belongsTo(Designer::class, 'designer_id', 'designer_id');
    }
}
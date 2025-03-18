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
        'rating',
        'comment',
        'is_visible'
    ];
    
    /**
     * Get the order associated with the review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    
    /**
     * Get the user who wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    /**
     * Get the production company being reviewed.
     */
    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id');
    }
}

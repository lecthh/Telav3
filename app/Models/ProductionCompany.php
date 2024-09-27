<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionCompany extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'company_logo', 'production_type', 'address', 'phone', 'avg_rating', 'review_count', 'apparel_type', 'email', 'user_id'];

    protected $casts = [
        'production_type' => 'array',
        'apparel_type' => 'array'
    ];

    public function productionType()
    {
        return $this->hasOne(ProductionType::class, 'id', 'production_type');
    }
}

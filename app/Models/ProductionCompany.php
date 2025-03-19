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
    public function productionCompanyPricing()
    {
        return $this->hasMany(ProductionCompanyPricing::class, 'production_company_id', 'id');
    }

    public function pricing()
    {
        return $this->hasMany(ProductionCompanyPricing::class, 'production_company_id');
    }

    public function getPriceFor($apparelTypeId, $productionTypeId, $isBulk = false)
    {
        $pricing = $this->pricing()
            ->where('apparel_type', $apparelTypeId)
            ->where('production_type', $productionTypeId)
            ->first();
            
        if (!$pricing) {
            return 0;
        }
        
        return $isBulk ? $pricing->bulk_price : $pricing->base_price;
    }
    
    /**
     * Get the reviews for this production company.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'production_company_id')
                    ->where('review_type', 'company');
    }
    
    
    /**
     * Update the average rating based on all visible reviews.
     */
    public function updateAverageRating()
    {
        $avgRating = $this->reviews()->where('is_visible', true)->avg('rating') ?? 0;
        $reviewCount = $this->reviews()->where('is_visible', true)->count();
        
        $this->avg_rating = round($avgRating, 1);
        $this->review_count = $reviewCount;
        $this->save();
        
        return $this->avg_rating;
    }
}

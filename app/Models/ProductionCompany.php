<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionCompany extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';

    protected $fillable = ['company_name', 'company_logo', 'production_type', 'address', 'phone', 'avg_rating', 'review_count', 'apparel_type', 'email', 'user_id', 'is_verified', 'status'];
    
    /**
     * Get the logo URL attribute.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->company_logo) {
            return asset('imgs/companyLogo/placeholder.jpg');
        }
        
        if (strpos($this->company_logo, 'imgs/') === 0) {
            return asset($this->company_logo);
        }
        
        // Handle direct storage reference
        if (strpos($this->company_logo, 'company_logos/') === 0) {
            return asset('storage/' . $this->company_logo);
        }
        
        return \Storage::disk('public')->url($this->company_logo);
    }

    protected $casts = [
        'production_type' => 'array',
        'apparel_type' => 'array'
    ];

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', self::STATUS_BLOCKED);
    }

    public function getApparelTypeNames()
    {
        $apparelIds = $this->apparel_type;

        if (!is_array($apparelIds)) {
            $apparelIds = json_decode($apparelIds, true);
            if (!is_array($apparelIds)) {
                $apparelIds = [];
            }
        }

        if (empty($apparelIds)) {
            return [];
        }

        return ApparelType::whereIn('id', $apparelIds)
            ->pluck('name')
            ->toArray();
    }

    public function getProductionTypeNames()
    {
        $productionTypeIds = $this->production_type;

        if (!is_array($productionTypeIds)) {
            $productionTypeIds = json_decode($productionTypeIds, true);
            if (!is_array($productionTypeIds)) {
                $productionTypeIds = [];
            }
        }

        if (empty($productionTypeIds)) {
            return [];
        }

        return ProductionType::whereIn('id', $productionTypeIds)
            ->pluck('name')
            ->toArray();
    }

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
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

    /**
     * Define the relationship to the business documents.
     */
    public function businessDocuments()
    {
        return $this->hasMany(BusinessDocument::class, 'production_company_id', 'id');
    }

    /**
     * Get the business permits for this production company.
     */
    public function getBusinessPermits()
    {
        return $this->businessDocuments()->where('name', 'business permit')->get();
    }
}

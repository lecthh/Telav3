<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
    use HasFactory;

    protected $table = 'designers';
    protected $primaryKey = 'designer_id';
    protected $fillable = [
        'user_id',
        'is_freelancer',
        'is_available',
        'production_company_id',
        'talent_fee',
        'max_free_revisions',
        'addtl_revision_fee',
        'designer_description',
        'order_history',
        'average_rating',
        'review_count',
    ];
    public $incrementing = true;
    protected $keyType = 'int';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'designer_id', 'designer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'designer_id', 'designer_id');
    }

    public function updateAverageRating()
    {
        $avgRating = $this->reviews()->where('is_visible', true)->avg('rating') ?? 0;
        $reviewCount = $this->reviews()->where('is_visible', true)->count();
        
        $this->average_rating = round($avgRating, 1);
        $this->review_count = $reviewCount;
        $this->save();
        
        return $this->average_rating;
    }
}

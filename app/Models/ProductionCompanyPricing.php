<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionCompanyPricing extends Model
{
    use HasFactory;
    protected $table = 'production_company_pricing';

    protected $primaryKey = 'pricing_id';

    protected $fillable = [
        'production_company_id',
        'apparel_type',
        'production_type',
        'base_price',
        'bulk_price',
    ];

    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id');
    }
    public function apparelType()
    {
        return $this->belongsTo(ApparelType::class, 'apparel_type');
    }
    public function productionType()
    {
        return $this->belongsTo(ProductionType::class, 'production_type');
    }
}

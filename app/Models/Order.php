<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'user_id',
        'production_company_id',
        'assigned_designer_id',
        'is_customized',
        'is_bulk_order',
        'quantity',
        'status_id',
        'apparel_type',
        'production_type',
        'downpayment_amount',
        'final_price',
        'custom_design_info',
        'revision_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id', 'production_company_id');
    }

    public function designer()
    {
        return $this->belongsTo(Designer::class, 'assigned_designer_id', 'designer_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'status_id');
    }

    public function apparelType()
    {
        return $this->belongsTo(ApparelType::class, 'apparel_type', 'id');
    }

    public function productionType()
    {
        return $this->belongsTo(ProductionType::class, 'production_type', 'id');
    }
}

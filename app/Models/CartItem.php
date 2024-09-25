<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [

        'cart_id',
        'apparel_type_id',
        'production_type',
        'quantity',
        'production_company_id',
        'price',
        'customization',
        'orderType',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function apparelType()
    {
        return $this->belongsTo(ApparelType::class, 'apparel_type_id');
    }
    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id');
    }

    public function productionType()
    {
        return $this->belongsTo(ProductionType::class, 'production_type');
    }

    public function cartItemImages()
    {
        return $this->hasMany(CartItemImages::class, 'cart_item_id', 'cart_item_id');
    }
}

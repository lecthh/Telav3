<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemImages extends Model
{
    use HasFactory;

    protected $table = 'cart_item_images';
    protected $fillable = ['cart_item_id', 'image'];


    public function cartItem()
    {
        return $this->belongsTo(CartItem::class, 'cart_item_id');
    }
}

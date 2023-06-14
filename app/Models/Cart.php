<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    use HasFactory;
    protected $fillable = [
        'customer_id', 'guest_token', 'product_id', 'price', 'quantity', 'sub_total', 'cart_order_no', 'coupon_id', 'coupon_amount', 'shipping_fee_id', 'shipping_fee'
    ];

    public function products()
    {
        return $this->hasOne( Product::class, 'id', 'product_id' );
    }

    public function addons()
    {
        return $this->hasMany(CartProductAddon::class, 'cart_id', 'id');
    }


    
}

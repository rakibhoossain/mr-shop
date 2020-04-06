<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    protected $table = 'order_items';

    protected $fillable = [
        'product_id', 'variation_value_id', 'quantity', 'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_value_id', 'variation_value_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
	    parent::boot();
	    static::creating(function ($query) {
	      $random = str_shuffle('AS32553DFGZWX0927466043161QPONM');
	      $query->code = 'ORD-'.substr($random,1,6);
	    });
	}

    use SoftDeletes;

    protected $fillable = [
        'payment_method', 'first_name', 'last_name', 'address', 'city', 'country', 'post_code', 'phone_number', 'notes', 'shipping_address', 'alternative_number'
// 'status', 'payment_status', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->items->sum('total_price');
    }
}


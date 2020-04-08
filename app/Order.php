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
// 'status', 'payment_status', 'shipping_method_id', 'transection_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all of the order's transections.
     */
    public function transections()
    {
        return $this->morphMany(Transection::class, 'transectionable');
    }
    

    public function getTotalPriceAttribute()
    {
        return $this->items->sum('total_price');
    }

    public function getChargeAttribute()
    {
        $charge = 0;
        if($this->shipping_method){
            if ($this->shipping_method->free_level !== null && $this->total_price >= $this->shipping_method->free_level) {
              $charge = 0;
            }
            $charge = $this->shipping_method->price;
        }
        return $charge;
    }

    public function getGrandTotalPriceAttribute()
    {
        return number_format((float)($this->total_price + $this->charge), 2, '.', '');
    }
}


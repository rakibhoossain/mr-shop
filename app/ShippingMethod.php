<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class ShippingMethod extends Model
{
    use SoftDeletes;
  	use Sluggable;

  	protected $fillable = ['name', 'description', 'price', 'free_level'];
  	protected $table = 'shipping_methods';

  	/*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
  	/**
   	* Return the sluggable configuration array for this model.
   	*
   	* @return array
   	*/
	public function sluggable()
	{
	  return [
	  	'slug' => [
	  		'source' => 'name'
	  	]
	  ];
	}
	public function getRouteKeyName()
	{
	  return 'slug';
	}

  public function orders()
  {
    return $this->hasMany(Order::class);
  }


	//Call only on Checkout shipping section
	public function getShippingChargeAttribute()
  {
    $total_price = 0;
    $cart = session()->get('cart');
    if($cart){
      foreach ($cart as $item) {
        $total_price += $item['price'] * $item['quantity'];
      }
    }
    if ($this->free_level !== null && $total_price >= $this->free_level) {
      return 0;
    }
    return $this->price;
  }


	protected $casts = [
    'price' => 'float',
    'free_level' => 'float',
  ];
}

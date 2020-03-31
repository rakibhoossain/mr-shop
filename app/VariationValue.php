<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariationValue extends Model
{
    use SoftDeletes;
    
    protected $table = 'variation_values';
    protected $fillable = ['name','data','type'];

    public function variation()
	{
	    return $this->belongsTo(Variation::class);
	}

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_variation_value')->withPivot('price', 'purchase_price', 'sell_price', 'quantity', 'image')->withTimestamps();
	}
}

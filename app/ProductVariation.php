<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class ProductVariation extends Model
{

	//Only convert DB to Eloquent... 
	protected $table = 'product_variation_value';

	public function variation_value()
	{
	    return $this->belongsTo(VariationValue::class);
	}

	public function getVariationAttribute()
	{
	    return $this->variation_value->variation;
	}

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Variation extends Model
{
    protected $table = 'variations';
    protected $fillable = ['name'];

   	use SoftDeletes;
	use Sluggable;
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	public function sluggable()
	{
		return [
		  	'slug' => [
		    	'source' => 'name'
		  	]
		];
	}

	// protected static function boot()
	// {
	//     self::deleting(function($variation) {
	//         $variation->values()->each(function($value) {
	//         	$value->delete();
	//         });
 //        });
	// }

	protected $with = ['values', 'variation_values'];

	public function getRouteKeyName()
	{
		return 'slug';
	}
	public function values()
	{
	    return $this->hasMany(VariationValue::class);
	}


	public function variation_values()
  	{
    	return $this->hasManyThrough(ProductVariation::class, VariationValue::class);
  	}
}
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
	public function getRouteKeyName()
	{
		return 'slug';
	}
	public function values()
	{
	    return $this->hasMany(VariationValue::class);
	}
}

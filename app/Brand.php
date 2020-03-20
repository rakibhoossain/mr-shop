<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
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
    protected $fillable = ['name', 'description', 'image'];

    public function products()
	{
	    return $this->hasMany(Product::class);
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Barcode extends Model
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
    protected $fillable = ['name', 'description', 'width', 'height', 'paper_width', 'paper_height', 'top_margin', 'left_margin', 'row_distance', 'col_distance', 'stickers_in_one_row', 'is_default', 'is_continuous', 'stickers_in_one_sheet'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'stickers_in_one_row' 	=> 'integer',
        'is_default' 			=> 'boolean',
        'is_continuous' 		=> 'boolean',
        'stickers_in_one_sheet' => 'integer',
    ];

}
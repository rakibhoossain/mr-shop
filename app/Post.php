<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
	use SoftDeletes;
    use Sluggable;

    protected $fillable = ['name', 'description', 'image'];

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

	public function categories()
  	{
    	return $this->morphToMany(Category::class, 'categoryable');
  	}
  	public function images()
	{
	   return $this->morphToMany(Image::class, 'imageable');
	}

	//comments
	public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

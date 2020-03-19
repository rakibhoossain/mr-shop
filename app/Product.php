<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
  use SoftDeletes;
  use Sluggable;

  /*
  |--------------------------------------------------------------------------
  | FUNCTIONS
  |--------------------------------------------------------------------------
  */
  protected static function boot()
  {
    parent::boot();
    static::creating(function ($query) {
      // $query->code = strtoupper(uniqid());

      $random = str_shuffle('AS32553DFGZWX0927466043161QPONM');
      $query->code = substr($random,1,6);
    });
  }

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

  protected $fillable = ['name', 'price', 'brand_id', 'purchase_price', 'alert_quantity', 'description'];

  protected $with = ['categories', 'images', 'sizes'];

  public function categories()
  {
    return $this->morphToMany(Category::class, 'categoryable');
  }
  public function images()
  {
    return $this->morphToMany(Image::class, 'imageable');
  }
  public function getImageAttribute()
  {
    return (count($this->images))? $this->images[0]->image : null;
  }

  public function sizes()
  {
    return $this->belongsToMany(Size::class, 'product_size');
  }
  public function brand()
  {
    return $this->belongsTo(Brand::class);
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Str;

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

  protected $fillable = ['name', 'price', 'brand_id', 'purchase_price', 'alert_quantity', 'description', 'excerpt', 'meta'];

  protected $with = ['categories', 'images', 'sizes', 'tags', 'variation_values'];

  public function categories()
  {
    return $this->belongsToMany(ProductCategory::class, 'product_category_product');
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

  public function tags()
  {
    return $this->belongsToMany(ProductTag::class, 'product_tag_product');
  }  

  public function variation_values()
  {
    return $this->belongsToMany(VariationValue::class , 'product_variation_value')->withPivot('price', 'purchase_price', 'sell_price', 'image')->withTimestamps();
  }

  public function getIsVariableAttribute()
  {
    return (count($this->variation_values))? true : false;
  }

  public function getTypeAttribute()
  {
    return ($this->is_variable)? 'Variable' : 'Normal';
  }

  public function brand()
  {
    return $this->belongsTo(Brand::class);
  }

  public function getSortDescriptionAttribute(){
    return ($this->excerpt)? $this->excerpt : ($this->description)? Str::words(strip_tags($this->description), 15, '...') : '';
  }

}

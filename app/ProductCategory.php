<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class ProductCategory extends Model
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

  protected $fillable = ['name', 'image', 'description', 'product_category_id'];
  protected $table = 'product_categories';

  public function products()
	{
  	return $this->belongsToMany(Product::class, 'product_category_product');
	}
  public function parent(){
    return $this->belongsTo(ProductCategory::class);
  }
  public function children(){
    return $this->hasMany(ProductCategory::class);
  }

  //Total Product
  public function getTotalProductAttribute(){
    return $this->products->count();
  }
  public function getTotalAttribute(){
    return (count($this->children))? $this->children->sum('total_product') : $this->total_product;
  }

}

<?php

use Illuminate\Database\Seeder;
use App\Brand;
use App\Category;
use App\ProductCategory;
use App\Image;

use App\Product;
use App\ProductTag;
use App\VariationValue;

use App\Post;

use App\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(PermissionTableSeeder::class);
    $this->call(AdminsTableSeeder::class);
    $this->call(SettingsTableSeeder::class);

    $this->call(VariationSeeder::class);
  
    factory(User::class, 100)->create();

    factory(Brand::class, 20)->create();
    factory(Category::class, 10)->create();
    factory(ProductCategory::class, 10)->create();
    factory(Image::class, 10)->create();
  
    factory(ProductTag::class, 10)->create();

    factory(Product::class, 100)->create()->each(function ($product) {
      $product->images()->save(Image::all()->random());
      $product->categories()->save(ProductCategory::all()->random());
      $product->tags()->save(ProductTag::all()->random());
    });

    factory(Product::class, 10)->create()->each(function ($product) {
      $product->images()->save(Image::all()->random());
      $product->categories()->save(ProductCategory::all()->random());
      $product->tags()->save(ProductTag::all()->random());
      $product->variation_values()->save(VariationValue::all()->random(), ['price' => rand(3, 70), 'sell_price' => rand(2, 94), 'purchase_price' => rand(1, 100), 'quantity' => rand(0, 10)]);
    });

    factory(Post::class, 20)->create()->each(function ($post) {
      $post->images()->save(Image::all()->random());
      $post->categories()->save(Category::all()->random());
    });
  }
}
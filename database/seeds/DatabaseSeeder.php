<?php

use Illuminate\Database\Seeder;
use App\Brand;
use App\Size;
use App\Category;
use App\ProductCategory;
use App\Image;

use App\Product;
use App\ProductTag;
use App\VariationValue;

use App\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VariationSeeder::class);
      
        $this->call(UsersTableSeeder::class);
        factory(Brand::class, 20)->create();
        $this->call(SizesTableSeeder::class);
        factory(Category::class, 10)->create();
        factory(ProductCategory::class, 10)->create();
        factory(Image::class, 10)->create();
      
        factory(ProductTag::class, 10)->create();

        factory(Product::class, 100)->create()->each(function ($product) {
            $product->images()->save(Image::all()->random());
            $product->categories()->save(ProductCategory::all()->random());
            $product->sizes()->save(Size::all()->random());
        });

		factory(Product::class, 10)->create()->each(function ($product) {
            $product->images()->save(Image::all()->random());
            $product->categories()->save(ProductCategory::all()->random());
            $product->sizes()->save(Size::all()->random());
            $product->variation_values()->save(Size::all()->random(), ['price' => rand(3, 100), 'purchase_price' => rand(1, 80)]);
        });

        factory(Post::class, 20)->create()->each(function ($post) {
            $post->images()->save(Image::all()->random());
            $post->categories()->save(Category::all()->random());
        });


    }
}

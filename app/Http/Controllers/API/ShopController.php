<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
// use App\Size;
use App\Brand;
use App\ProductCategory;
use App\Variation;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = Product::with(['categories' => function($ctegory){
            $ctegory->select('name', 'slug');
        }, 'images' => function($image){
            $image->select('image');
        }, 'tags' => function($tag){
            $tag->select('name', 'slug');
        }, 'variation_values' => function($variation_value){
            $variation_value->select('name');
        }]);

        // if(!empty($_GET['category'])){
        //     $slugs = explode(',', $_GET['category']);
        //     $cat_ids = Category::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
        //     $products->whereIn('category_id',  $cat_ids);
        // }        

        if(!empty($_GET['varient'])){
            $ids = explode(',', $_GET['varient']);
            $query->whereHas('variation_values', function($q) use($ids){
                $q->whereIn('variation_values.id',  $ids);
            });
        }

        if(!empty($_GET['brand'])){
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            $query->whereIn('brand_id',  $brand_ids);
        }
        // if(!empty($_GET['size'])){
        //     $slugs = explode(',', $_GET['size']);
        //     $size_ids = Size::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
        //     $query->whereHas('sizes', function($q) use($size_ids){
        //         $q->whereIn('size_id',  $size_ids);
        //     });
        // }

        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy'] == 'newest'){
                $query->orderBy('created_at', 'desc');
            }            
            if($_GET['sortBy'] == 'oldest'){
                $query->orderBy('created_at', 'asc');
            }            
            if($_GET['sortBy'] == 'lowest-price'){
                $query->orderBy('price', 'asc');
            }
            if($_GET['sortBy'] == 'heigh-price'){
                $query->orderBy('price', 'desc');
            }
        }

        if(!empty($_GET['price'])){
            $price = explode('-', $_GET['price']);
            if(isset($price[0]) && is_numeric($price[0])) $price[0] = floor($price[0]);
            if(isset($price[1]) && is_numeric($price[1])) $price[1] = ceil($price[1]);
            $query->whereBetween('price', $price);
        }

        return $query->select('id', 'name', 'slug', 'price', 'sell_price')->paginate(10);
    }


    public function shopFilterData(){
        $brands = Brand::has('products')->select('name', 'slug')->withCount('products')->orderBy('products_count', 'desc')->get();

        $categories = ProductCategory::whereNull('product_category_id')->with(['children' => function($child_cat){
            $child_cat->has('products')->select('id', 'name', 'slug', 'product_category_id')->withCount('products');
        }])->has('products')->select('id', 'name')->withCount('products')->orderBy('products_count', 'desc')->get();

        $variations = Variation::with(['values'  => function($value){
            $value->has('products')->has('products')->select('id', 'variation_id', 'name')->withCount('products');
        }])->without('variation_values')->has('variation_values')->select('id', 'name')->get();

        return response()->json([
            'brands'    => $brands,
            'categories'    => $categories,
            'variations'    => $variations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

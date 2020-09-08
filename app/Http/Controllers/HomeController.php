<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Size;
use App\Brand;
use App\ProductCategory;
use App\Variation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.index');
    }    
    public function contact()
    {
        return view('frontend.contact');
    }

    public function shop(Request $request){
        // $sizes = Size::has('products')->latest()->get();
        $brands = Brand::has('products')->select('name', 'slug')->withCount('products')->orderBy('products_count', 'desc')->get();
        
        $categories = ProductCategory::whereNull('product_category_id')->with(['children' => function($child_cat){
            $child_cat->has('products')->select('id', 'name', 'slug', 'product_category_id')->withCount('products');
        }])->has('products')->select('id', 'name')->withCount('products')->orderBy('products_count', 'desc')->get();

        $variations = Variation::with(['values'  => function($value){
            $value->has('products')->has('products')->select('id', 'variation_id', 'name')->withCount('products');
        }])->without('variation_values')->has('variation_values')->select('id', 'name')->get();

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

        $products = $query->select('id', 'name', 'slug', 'price', 'sell_price')->paginate(10);
        return view('frontend.shop', compact('products', 'brands', 'categories', 'variations'));
    }
    public function singleProduct(Request $request, Product $product){

        $varients = $product->variation_values()->get()->groupBy(function($d) {
            return $d->variation->id;
        });

        if($request->ajax()){
            return response()->json([
                'success' => true,
                'html' => view('frontend.partials.product_modal_html', compact('product', 'varients'))->render()
            ]);
        }

        $categories = $product->categories->modelKeys();
        $relatedProducts = Product::whereHas('categories', function ($q) use ($categories) {
            $q->whereIn('product_categories.id', $categories);
        })->where('id', '<>', $product->id)->get();

        return view('frontend.product.single', compact('product','relatedProducts', 'varients'));
    }

    public function filter(Request $request)
    {
        $data = $request->all();

        $catURL = '';
        // if(!empty($data['category'])){
        //     foreach($data['category'] as $category){
        //         if(empty($catURL)){
        //             $catURL .= '&category='.$category;
        //         }else{
        //             $catURL .= ','.$category;
        //         }
        //     }
        // }

        $brandURL = '';
        if(!empty($data['brand'])){
            foreach($data['brand'] as $brand){
                if(empty($brandURL)){
                    $brandURL .= '&brand='.$brand;
                }else{
                    $brandURL .= ','.$brand;
                }
            }
        }        

        $varientURL = '';
        if(!empty($data['varient'])){
            foreach($data['varient'] as $varient){
                if(empty($varientURL)){
                    $varientURL .= '&varient='.$varient;
                }else{
                    $varientURL .= ','.$varient;
                }
            }
        }

        $sortByURL = '';
        if(!empty($data['sortBy'])){
            $sortByURL .= '&sortBy='.$data['sortBy'];
        }        

        $sizeURL = '';
        if(!empty($data['size'])){
            $sizeURL .= '&size='.$data['size'];
        }

        $showURL = '';
        // if(!empty($data['show'])){
        //     $showURL .= '&show='.$data['show'];
        // }

        $price_range_URL = '';
        if(!empty($data['price_range'])){
            $price_range_URL .= '&price='.$data['price_range'];
        }
        return redirect()->route('shop',$catURL.$brandURL.$price_range_URL.$showURL.$sizeURL.$varientURL.$sortByURL);
    }
}

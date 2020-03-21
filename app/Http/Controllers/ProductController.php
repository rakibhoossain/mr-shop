<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if($request->search){
            $search_string = $request->search;
            $products->where('name', 'like', '%'.$search_string.'%' )
            ->orWhere('code', 'like', '%'.$search_string.'%' )
            ->orWhere('price', 'like', '%'.$search_string.'%' )
            ->orWhere('description', 'like', '%'.$search_string.'%' )
            ->orWhereHas('brand', function($q) use($search_string){
                $q->where('name', 'like', '%'.$search_string.'%' );
            })
            ->orWhereHas('sizes', function($q) use($search_string){
                $q->where('name', 'like', '%'.$search_string.'%' );
            });
        }
        $products = $products->latest()->paginate(20);
        if($products){
            return view('dashboard.product.index', compact('products'));
        }else{
            dd();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $input = $request->except(['description', 'meta']);

        $keys = $request->keys;
        $values = $request->values;
        if ($keys && $values) {
            $data = [];
            foreach($keys as $k => $key){
                if(is_null($key) || is_null($values[$k]) ) continue;
                array_push($data, ['key' => $key, 'value' => $values[$k]]);
            }
            if(count($data)) $input['meta'] = json_encode(compact('data'));
        }

        //Product Description
        if($request->description){
            $input['description'] = $this->productDetail($request->input('description'));
        }
        $product = auth()->user()->products()->create($input);
        if($product){
            if($request->images){
                $image_ids = $this->uploadProductImages($request->images);
                if(count($image_ids)) $product->images()->attach($image_ids);
            }       
            if($request->categories){
                $product->categories()->attach($request->categories);
            }

            if($product->tags){
                $product->tags()->attach($request->tags);
            }

            return $product;
        }else{
            dd('Something went wrong!');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    private function productDetail($detail){
        $dom = new \DomDocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/images/" . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        return $dom->saveHTML();
    }

    private function uploadProductImages($images){
        $img_ids = [];
        foreach($images as $image){
        // if a base64 was sent, store it in the db
            if (!is_null($image) && strpos($image, 'data:image') == 0){
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);
                $image_name= time().'.png';
                $location = '/images/'.$image_name;

                $path = public_path() . $location;
                file_put_contents($path, $data);

                $image_db = Image::create(['image' => $location]);
                if($image_db) array_push($img_ids, $image_db->id);

                // Image::make($image)->save( public_path($location) );

                //Delete old feature image
                // if($feature->image) {
                //     $old_image = public_path($feature->image);
                //     if ( file_exists($old_image) ) unlink($old_image);
                // }
            }
        }
        return $img_ids;

    }
}

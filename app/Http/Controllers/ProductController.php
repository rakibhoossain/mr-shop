<?php

namespace App\Http\Controllers;

use App\Product;
use App\Variation;
use App\VariationValue;
use App\Image as ImageModel;
use Illuminate\Http\Request;
use Storage;
use Image;

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
            });
        }
        $products = $products->latest()->paginate(20);
        if($products){
            return view('dashboard.product.index', compact('products'));
        }else{
            dd();
        }





    }

    public function collection(){
        return 'oh';
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

    public function varientField(Request $request)
    {
        if($request->ajax()){
            if($request->varient_create && $request->varient_create == 'varient'){
                return response()->json([
                    'success' => true,
                    'html' => view('dashboard.product.varient.create')->render()
                ]);
            }elseif($request->variation){
                $variation = Variation::find($request->variation);
                if($variation) return response()->json([
                    'success' => true,
                    'id' => $variation->id,
                    'html' => view('dashboard.product.varient.select', compact('variation'))->render()
                ]);
            }elseif($request->varient){
                $value = VariationValue::find($request->varient);
                if($value) return response()->json([
                    'success' => true,
                    'id' => $value->id,
                    'html' => view('dashboard.product.varient.field', compact('value'))->render()
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'html' => ''
                ]); 
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
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
                if($request->variations){
                    foreach($request->variations as $k => $variation){
                        foreach($variation as $id){
                            $purchase_price = $request->varient_purchase_prices[$k][$id];
                            $sell_price = $request->varient_sell_prices[$k][$id];
                            $offer_price = $request->varient_prices[$k][$id];

                            $image = $request->varient_images[$k][$id];
                            $varient_image = ($image)? $this->uploadVarientImages($image) : null;

                            $product->variation_values()->attach($id, [
                                'price' => $offer_price,
                                'sell_price' => $sell_price,
                                'purchase_price' => $purchase_price,
                                'purchase_price' => $purchase_price,
                                'quantity' => $request->varient_quantities[$k][$id],
                                'image' => $varient_image,
                            ]);
                        }
                    }
                }
                return $product;
            }else{
                throw new \Exception('Invalid action!');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        $varients = $product->variation_values()->get()->groupBy(function($d) {
            return $d->variation->id;
        });
        return view('dashboard.product.edit', compact('product', 'varients'));
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


        try {
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
            if($product->update($input)){
                if($request->images){
                    $image_ids = $this->uploadProductImages($request->images);
                    if(count($image_ids)) $product->images()->attach($image_ids);
                }
                if($request->image_dels){
                    $this->deleteProductImages($request->image_dels, $product);
                }  
                if($request->categories){
                    $product->categories()->detach(); //Delete old categories
                    $product->categories()->attach($request->categories);
                }
                if($product->tags){
                    $product->tags()->detach(); //Delete old tags
                    $product->tags()->attach($request->tags);
                }
                
                $product->variation_values()->detach(); //Delete old variations

                if($request->variations){
                    foreach($request->variations as $k => $variation){
                        foreach($variation as $id){
                            $purchase_price = $request->varient_purchase_prices[$k][$id];
                            $sell_price = $request->varient_sell_prices[$k][$id];
                            $offer_price = $request->varient_prices[$k][$id];

                            $image = $request->varient_images[$k][$id];
                            $varient_image = ($image)? $this->uploadVarientImages($image) : $request->v_img_old[$k][$id];

                            $product->variation_values()->attach($id, [
                                'price' => $offer_price,
                                'sell_price' => $sell_price,
                                'purchase_price' => $purchase_price,
                                'purchase_price' => $purchase_price,
                                'quantity' => $request->varient_quantities[$k][$id],
                                'image' => $varient_image,
                            ]);
                        }
                    }
                }
                return back();
            }else{
                throw new \Exception('Invalid action!');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


























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
        $dom = new \DOMDocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $image = $img->getAttribute('src');
            // if a base64 was sent, store it in the db
            if (!is_null($image) && preg_match('/data:image/', $image)){
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);

                // $post_image = Image::make($data)->resize(1000, 1200)->encode('jpg', 95);
                $post_image_location = 'posts/'.md5(microtime().$k).'.jpg';
                Storage::disk('public')->put($post_image_location, $data);

                // list($type, $image) = explode(';', $image);
                // list(, $image)      = explode(',', $image);
                // $data = base64_decode($image);
                // $image_name= time().$k.'.png';
                // $location = '/images/'.$image_name;
                // $path = public_path() . $location;
                // file_put_contents($path, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', 'storage/'.$post_image_location);
            }
        }
        return $dom->saveHTML();
    }

    private function uploadProductImages($images){
        $img_ids = [];
        foreach($images as $image){
        // if a base64 was sent, store it in the db
            if (!is_null($image) && preg_match('/data:image/', $image)){
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $data = base64_decode($image);

                $lg_image_location = 'products/'.md5(microtime()).'.jpg';
                Storage::disk('public')->put($lg_image_location, $data);

                $image_db = ImageModel::create(['image' => 'storage/'.$lg_image_location]);
                if($image_db) array_push($img_ids, $image_db->id);

                // Image::make($image)->save( public_path($location) );
            }
        }
        return $img_ids;
    }
    private function uploadVarientImages($image){
        // if a base64 was sent, store it in the db
        if (!is_null($image) && preg_match('/data:image/', $image)){
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $data = base64_decode($image);
            $lg_image_location = 'products/'.md5(microtime()).'.jpg';
            Storage::disk('public')->put($lg_image_location, $data);
            return 'storage/'.$lg_image_location;
        }
    }

    private function deleteProductImages($ids, $product){
        $images = $product->images()->whereIN('images.id', (array)$ids)->get();
        $product->images()->detach($images);
    }
}

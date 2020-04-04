<?php

namespace App\Http\Controllers;

use App\Product;
use App\Variation;
use App\VariationValue;
use App\Barcode;
use App\Image as ImageModel;
use Illuminate\Http\Request;
use Storage;
use Image;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show', 'collection']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $this->middleware('permission:stock', ['only' => ['stocks', 'stockCollection']]);
        $this->middleware('permission:barcode', ['only' => ['labelPrint', 'labelPrintPreview']]);
    }

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
        return ProductResource::collection(Product::latest()->get());
    }
    public function stockCollection(){
        $data = [];
        $products = Product::latest()->get();

        foreach($products as $product){
            $brand = ($product->brand)? $product->brand->name : '';
            $image = ($product->image)? "<img src='".asset($product->image)."' width='50' height='50'>" : '';
            $item =  [
                'code' => $product->code,
                'name' => $product->name,
                'image' => $image,
                'purchase_price' => $product->purchase_price,
                'sell_price' => $product->sell_price,
                'offer_price' => $product->price,
                'categories' => $product->categories->implode('name', ', '),
                'brand' => $brand,
                'type' => $product->type,
                'quantity' => $product->quantity,
                'created_at' => \Carbon\Carbon::parse($product->created_at)->timestamp,
            ];
            array_push($data, $item);
            foreach ($product->variation_values as $value) {
                $v_image = ($value->pivot->image)? "<img src='".asset($value->pivot->image)."' width='50' height='50'>" : $image;
                $v_item =  [
                    'code' => $product->code.'-'.$value->id,
                    'name' => $product->name.' ('.$value->name.')',
                    'image' => $v_image,
                    'purchase_price' => ($value->pivot->purchase_price > 0)? $value->pivot->purchase_price : $product->purchase_price,
                    'sell_price' => ($value->pivot->sell_price > 0)? $value->pivot->sell_price : $product->sell_price,
                    'offer_price' => ($value->pivot->price > 0)? $value->pivot->price : $product->price,
                    'categories' => $product->categories->implode('name', ', '),
                    'brand' => $brand,
                    'type' => $product->type,
                    'quantity' => $value->pivot->quantity,
                    'created_at' => \Carbon\Carbon::parse($product->created_at)->timestamp,
                ];
                array_push($data, $v_item);
            }
        }

        return response()->json(['data' => $data]);
    }
    public function stocks(){
        return view('dashboard.product.stocks');
    }

    public function labelPrint(Request $request){
        if ($request->ajax()) {
            $search = $request->search;
            $varient = null;
            if(strpos($search, '-') !== false) {
                $seperate_search = explode('-', $search);
                $search = $seperate_search[0];
                $varient = $seperate_search[1];
            }
            $product = Product::Where('name', 'like', '%'.$search.'%' )->orWhere('code', 'like', '%'.$search.'%' )->first();

            if($product){
                if($varient && $product->has('variation_values')) {
                    $variation = $product->variation_values()->where('variation_values.id', $varient)->first();
                    if($variation){
                        $code = $product->code.'-'.$varient;
                        return response()->json([
                            'success' => true,
                            'code'  => $code,
                            'html' => view('dashboard.product.barcode.varient_product', compact('product', 'variation', 'code'))->render()
                        ]);                        
                    }
                }
                return response()->json([
                    'success' => true,
                    'code'  => $product->code,
                    'html' => view('dashboard.product.barcode.single_product', compact('product'))->render()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No product matched!'
            ]);

        }
        return view('dashboard.product.barcode.index');
    }
    public function labelPrintPreview(Request $request){
        $print = $request->print;
        $barcodes = $request->barcodes;
        $barcode_setting = $request->barcode_setting;
        $barcode_details = Barcode::find($barcode_setting);

        $total_qty = 0;
        foreach ($barcodes as $qty) {
            $total_qty += $qty;
        }

        if ($barcode_details->is_continuous) {
            $rows = ceil($total_qty/$barcode_details->stickers_in_one_row) + 0.4;
            $barcode_details->paper_height = $barcode_details->top_margin + ($rows*$barcode_details->height) + ($rows*$barcode_details->row_distance);
        }

        $barcode_details->barcode_type = 'C128';

        return response()->json([
            'success' => true,
            'html' => view('dashboard.product.barcode.preview', compact('print', 'barcodes', 'barcode_details'))->render()
        ]);
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
                            $purchase_price = (isset($request->varient_purchase_prices[$k][$id]))? $request->varient_purchase_prices[$k][$id] : null;
                            $sell_price = (isset($request->varient_sell_prices[$k][$id]))? $request->varient_sell_prices[$k][$id] : null;
                            $offer_price = (isset($request->varient_prices[$k][$id]))? $request->varient_prices[$k][$id] : null;

                            $image = (isset($request->varient_images[$k][$id]))? $request->varient_images[$k][$id] : null;
                            $varient_image = ($image)? $this->uploadVarientImages($image) : null;

                            $product->variation_values()->attach($id, [
                                'price' => $offer_price,
                                'sell_price' => $sell_price,
                                'purchase_price' => $purchase_price,
                                'purchase_price' => $purchase_price,
                                'quantity' => (isset($request->varient_quantities[$k][$id]))? $request->varient_quantities[$k][$id] : 0,
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
                            $purchase_price = (isset($request->varient_purchase_prices[$k][$id]))? $request->varient_purchase_prices[$k][$id] : $product->purchase_price;
                            $sell_price = (isset($request->varient_sell_prices[$k][$id]))? $request->varient_sell_prices[$k][$id] : $product->sell_price;
                            $offer_price = (isset($request->varient_prices[$k][$id]))? $request->varient_prices[$k][$id] : $product->price;

                            $image = (isset($request->varient_images[$k][$id]))? $request->varient_images[$k][$id] : null;
                            $varient_image = ($image)? $this->uploadVarientImages($image) : (isset($request->v_img_old[$k][$id]))? $request->v_img_old[$k][$id] : null;

                            $product->variation_values()->attach($id, [
                                'price' => $offer_price,
                                'sell_price' => $sell_price,
                                'purchase_price' => $purchase_price,
                                'quantity' => (isset($request->varient_quantities[$k][$id]))? $request->varient_quantities[$k][$id] : 0,
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
        if($product->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Product moved to trash!'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong!'
            ]);
        }
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

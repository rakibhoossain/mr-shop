<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.cart');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request, Product $product)
    {
        // $product_code = $product->code;
        // $varient_id = null;

        // if(strpos($product_code, '-') !== false) {
        //     $codeArr = explode('-', $code);
        //     $product_code = $codeArr[0];
        //     $varient_id = $codeArr[1];
        // }

        $variation = ($request->varient)? $product->variation_values()->where('variation_values.id', $request->varient)->first() : null;

        $cart = session()->get('cart');
        $id = ($variation)? $product->code.'-'.$variation->id : $product->code;

        $name = ($variation)? $product->name.' ('.$variation->name.')' : $product->name;
        $varient_label = ($variation)? $variation->variation->name.': '.$variation->name : '';
        $price = ($variation)? ($variation->pivot->price > 0)? $variation->pivot->price : $product->price : $product->price;
        $sell_price = ($variation)? ($variation->pivot->sell_price > 0)? $variation->pivot->sell_price : $product->sell_price : $product->sell_price;
        $thumb = ($variation)? ($variation->pivot->image)? $variation->pivot->image : $product->image : $product->image;
        $product_id = $product->id;
        $varient_id = ($variation)? $variation->id : null;
        $max = ($variation)? ($variation->pivot->quantity) : $product->quantity;

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += ($request->quantity)? $request->quantity : 1;
            session()->put('cart', $cart);
        }else{
            // if item not exist in cart then add to cart with quantity
            $cart[$id] = [
                "name" => $name,
                "slug" => $product->slug,
                "varient_label" => $varient_label,
                "quantity" => ($request->quantity)? $request->quantity : 1,
                "price" => $price,
                "sell_price" => $sell_price,
                "thumb" => $thumb,
                "product_id" => $product_id,
                "variation_value_id" => $varient_id,
                "max" => $max
            ];
            session()->put('cart', $cart);
        }
        return back();
    }


    public function cartUpdate(Request $request)
    {
        if($request->carts){
            $cart = session()->get('cart');
            foreach($request->carts as $id => $quantity){
                if(isset($cart[$id])) {
                    $cart[$id]['quantity'] = $quantity;
                    session()->put('cart', $cart);
                }
            }
        }
        return back();
    }





    //Remove from cart
    public function removeFromCart($code)
    {
        if($code) {
            $cart = session()->get('cart');
            if(isset($cart[$code])) {
                unset($cart[$code]);
                session()->put('cart', $cart);
            }
            return back()->with('success', 'Product removed successfully!');
        }
        return back()->withErrors('Invalid action');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout($step = 'step1'){
        $invoice = session()->get('checkout_invoice');
        $shipping = session()->get('checkout_shipping');
        return view('frontend.checkout.'.$step, compact('invoice', 'shipping'));
    }

    public function checkoutStoreStep1(Request $request){
        $request->validate([
            'invoice.first_name'            => 'required|max:165',
            'invoice.last_name'             => 'required|max:165',
            'invoice.phone_number'          => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'invoice.alternative_number'    => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'invoice.country'               => 'required',
            'invoice.city'                  => 'required',
            'invoice.post_code'             => 'required|numeric',
            'invoice.address'               => 'required',

            'invoice.another' => 'nullable',

            'shipping.first_name' => 'nullable|required_with:invoice.another|max:165',
            'shipping.last_name' => 'nullable|required_with:invoice.another|max:165',
            'shipping.phone_number' => 'nullable|required_with:invoice.another|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'shipping.alternative_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'shipping.country' => 'nullable|required_with:invoice.another',
            'shipping.city' => 'nullable|required_with:invoice.another',
            'shipping.post_code' => 'nullable|required_with:invoice.another|numeric',
            'shipping.address' => 'nullable|required_with:invoice.another',
        ]);

        if($request->invoice) {
            session()->put('checkout_invoice', $request->invoice);
        }

        if(!empty($request->invoice['another']) && $request->shipping) {
            session()->put('checkout_shipping', $request->shipping);
        }else{
            session()->put('checkout_shipping', null);
        }

        return redirect(route('checkout', 'step2'));
    }

    public function checkoutStoreStep2(Request $request){
        return redirect(route('checkout', 'step3'));
    }
    public function checkoutStoreStep3(Request $request){
        return redirect(route('checkout', 'step4'));
    }
    public function checkoutStoreStep4(Request $request){
        return redirect(route('checkout', 'step5'));
    }    
    public function checkoutFinal(){

        $cart = session()->get('cart');
        $invoice = session()->get('checkout_invoice');
        $shipping = session()->get('checkout_shipping');

        if($cart && $invoice){
            $order = auth()->user()->orders()->create($invoice);
            if($shipping){
                $order->update(['shipping_address' => json_encode(compact('shipping'))]);
            }
            foreach ($cart as $key => $item) {
                $order->items()->create($item);
            }

            $order_url = route('order.view', [auth()->user()->id, $order->id]);

            session()->put('cart', null);
            // session()->put('checkout_invoice', null);
            // session()->put('checkout_shipping', null);
            
            return view('frontend.checkout.final', compact('order_url'));
        }else{
            return redirect(route('shop'));
        }  
    }









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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
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
}

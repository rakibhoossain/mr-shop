<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\ShippingMethod;
use Illuminate\Http\Request;
use DB;
use Stripe;
use Session;
use Shop;

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

        $product_price = ($variation)? ($variation->pivot->price > 0)? $variation->pivot->price : $product->price : $product->price;
        $sell_price = ($variation)? ($variation->pivot->sell_price > 0)? $variation->pivot->sell_price : $product->sell_price : $product->sell_price;

        $price = ($sell_price > 0)? $sell_price : $product_price;

        $thumb = ($variation)? ($variation->pivot->image)? $variation->pivot->image : $product->image : $product->image;
        $product_id = $product->id;
        $varient_id = ($variation)? $variation->id : null;

        $max = ($variation)? ($variation->pivot->quantity) : $product->quantity;
        $busket_qty = Shop::totalCartItem($id);
        $avaliable_quantity = ($max - $busket_qty);
        $single_cart_quantity = (isset($request->quantity))? $request->quantity : 1;

        if($single_cart_quantity <= 0) return back()->withError('Invalid quantity!');
        if($avaliable_quantity <= 0) return back()->withError($name .' not avaliable!');
        if($single_cart_quantity > $avaliable_quantity) return back()->with('warning', $name .' only '.$single_cart_quantity. ' items avaliavbe!');

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $single_cart_quantity;
            session()->put('cart', $cart);
        }else{
            // if item not exist in cart then add to cart with quantity
            $cart[$id] = [
                "id" => $id,
                "name" => $name,
                "slug" => $product->slug,
                "varient_label" => $varient_label,
                "quantity" => $single_cart_quantity,
                "price" => $price,
                // "sell_price" => $sell_price,
                "thumb" => $thumb,
                "product_id" => $product_id,
                "variation_value_id" => $varient_id,
                "max" => $max
            ];
            session()->put('cart', $cart);
        }
        return back()->with('success', $name .' added to cart!.');
    }


    public function cartUpdate(Request $request)
    {
        if($request->carts){
            $errors = [];
            $cart = session()->get('cart');
            foreach($request->carts as $id => $quantity){
                if(isset($cart[$id])) {
                    $max = Shop::cartItemMaxAvailable($id);
                    $selected = $cart[$id]['quantity'];
                    if( $max >= ($quantity -$selected) ){
                        $cart[$id]['quantity'] = $quantity;
                    }else{
                        $errors[$id] = $cart[$id]['name'].' only '.( $max + $selected). ' items avaliavbe!';
                    }
                    session()->put('cart', $cart);
                }
            }
            if(count($errors)) return back()->withErrors($errors);
        }
        return back()->with('Cart update success!.');
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
        return back()->withError('Invalid action');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request, $step = 'step1'){
        $invoice = session()->get('checkout_invoice');
        $shipping = session()->get('checkout_shipping');
        $stripe = session()->get('checkout_stripe');
        $payment_type = session()->get('checkout_payment_type');
        $shippping_method = session()->get('shippping_method');
 
        $checkout_steps = (array)session()->get('checkout_steps'); //step history

        if(\View::exists('frontend.checkout.'.$step) ) {
            $step_n = (int)$step[strlen($step)-1];
            if( ($step_n !== 1) && !array_key_exists($step_n, $checkout_steps) ){
                return redirect()->back();
            }
            return view('frontend.checkout.'.$step, compact('invoice', 'shipping', 'stripe', 'payment_type', 'checkout_steps', 'shippping_method'))->with('step', $step);
        }else{
            return view('frontend.checkout.step1', compact('invoice', 'shipping', 'stripe', 'payment_type', 'checkout_steps', 'shippping_method'))->with('step', 'step1');
        }
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
        $step = session()->get('checkout_steps');
        $step[2] = 'step2';
        session()->put('checkout_steps', $step);
        return redirect(route('checkout', 'step2'));
    }

    public function checkoutStoreStep2(Request $request){
        $request->validate([
            'shippping_method' => 'required|exists:shipping_methods,id'
        ]);

        $shippping_method = ShippingMethod::find($request->shippping_method);

        if($shippping_method){
            session()->put('shippping_method', [
                'id' => $shippping_method->id,
                'charge' => $shippping_method->shipping_charge,
                'name' => $shippping_method->name,
            ]);

            $step = session()->get('checkout_steps');
            $step[3] = 'step3';
            session()->put('checkout_steps', $step);
            return redirect(route('checkout', 'step3'));            
        }else{
            return back()->with('error', 'Invalid delivary method!');
        }
    }
    public function checkoutStoreStep3(Request $request){
        $request->validate([
            'payment.type' => 'required|in:stripe,cash,bKash,rocket,card',
        ]);
        session()->put('checkout_payment_type', $request->payment['type']);

        $request->validate([
            'stripe.name'     => 'nullable|required_if:payment.type,stripe',
            'stripe.number'   => 'nullable|required_if:payment.type,stripe',
            'stripe.cvc'      => 'nullable|required_if:payment.type,stripe',
            'stripe.month'    => 'nullable|required_if:payment.type,stripe',
            'stripe.year'     => 'nullable|required_if:payment.type,stripe',
            'stripe.token'    => 'nullable|required_if:payment.type,stripe',
        ]);

        if($request->stripe && $request->stripe['token']){
            session()->put('checkout_stripe', $request->stripe);
        }else{
            session()->put('checkout_stripe', null);
        }
        $step = session()->get('checkout_steps');
        $step[4] = 'step4';
        session()->put('checkout_steps', $step);
        return redirect(route('checkout', 'step4'));
    }
   
    public function checkoutFinal(){
        $cart = session()->get('cart');
        $invoice = session()->get('checkout_invoice');
        $shipping = session()->get('checkout_shipping');
        $payment_type = session()->get('checkout_payment_type');
        $shippping_method = session()->get('shippping_method');

        if($cart && $invoice && $payment_type){
            DB::beginTransaction();
            try{
                $order = auth()->user()->orders()->create($invoice);
                if($shipping){
                    $order->update(['shipping_address' => json_encode(compact('shipping'))]);
                }
                foreach ($cart as $key => $item) {
                    $order->items()->create($item);
                }

                if($shippping_method && isset($shippping_method['id'])){
                    $order->update(['shipping_method_id' => $shippping_method['id'] ]);
                }else{
                    throw new \Exception('Shipping method invalid! Please try again!');
                }
                

                $stripe = session()->get('checkout_stripe');
                if($stripe && $payment_type == 'stripe'){
                    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $result = Stripe\Charge::create ([
                        "amount" => $order->grand_total_price *100,
                        "currency" => "usd",
                        "source" => $stripe['token'],
                        "description" => "Order payment ".$order->code,
                    ]);
                    if(!$result->paid) throw new \Exception('Payment failed! Please try again!');

                    $order->transections()->create([
                        'type' => $payment_type,
                        'TxnId' => $result->balance_transaction,
                        'amount' => $order->grand_total_price,
                        'status' => 'paid'
                    ]);
                }

                DB::commit();
                $order_url = route('order.view', [auth()->user()->id, $order->code]);
                session()->put('cart', null);
                session()->put('checkout_steps', null);
                session()->put('checkout_stripe', null);
                session()->put('checkout_payment_type', null);
                session()->put('shippping_method', null);
                // session()->put('checkout_invoice', null);
                // session()->put('checkout_shipping', null);
                
                return view('frontend.checkout.final', compact('order_url'));
            }catch(\Exception $e){
                DB::rollback();
                return back()->withErrors($e->getMessage());
            }
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

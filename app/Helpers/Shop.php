<?php
namespace App\Helpers;
use App\Product;

class Shop{

	public static function productMinPrice(){
		return floor(Product::min('price'));
	}
	public static function productMaxPrice(){
		return ceil(Product::max('price'));
	}

	//cart functions
	public static function currency(){
		return '৳';
	}
	public static function frontendPrice($price){
		$price = $price?? 0; 
		return self::currency().''.$price;
	}	
	public static function totalCartPrice(){
		$price = 0;
		$cart = session()->get('cart');
		if($cart){
			foreach ($cart as $item) {
				$price += $item['price'] * $item['quantity'];
			}
		}
		return $price;
	}
	public static function totalCartItem($id = null){
		$cart = collect(session()->get('cart'));
		if(!is_null($id)){
			$cart = $cart->where('id', $id);
		}
		return $cart->sum('quantity');
		// $total = 0;
		// $cart = session()->get('cart');
		// if($cart){
		// 	foreach ($cart as $item) {
		// 		$total += $item['quantity'];
		// 	}
		// }
		// return $total;
	}
	public static function cartItemMaxAvailable($id){
		$max = collect(session()->get('cart'))->where('id', $id)->sum('max');
		return $max - self::totalCartItem($id);
	}
	public static function getCartGrandPrice(){
		$cart_price = self::totalCartPrice(false);

		$shippping_method = session()->get('shippping_method');
		$shipping_charge = (isset($shippping_method['charge']))? $shippping_method['charge'] : 0;

		$grand_price = number_format((float)($cart_price + $shipping_charge), 2, '.', '');
		return self::frontendPrice($grand_price);
	}
	//cart functions end

	//original 	- sell_price
	//current 	- offer_price / sell_price
	public static function frontendItemPrice($item, $option = 'current'){
		$original_price = ($item->price)? $item->price : 0;
		$sell_price = ($item->sell_price)? $item->sell_price : 0;
		$offer_price = $original_price - $sell_price;

		if($option == 'original'){
			if($offer_price == $original_price){
				return '';
			}else{
				return self::frontendPrice($original_price);
			}
		}

		$current_price = ($sell_price > 0)? $sell_price : $original_price;
		return self::frontendPrice($current_price);
	}

}
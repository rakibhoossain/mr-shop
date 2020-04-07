<?php
namespace App\Helpers;
use App\Product;

class Helper{

	public static function productMinPrice(){
		return floor(Product::min('price'));
	}
	public static function productMaxPrice(){
		return ceil(Product::max('price'));
	}

	//cart functions
	public static function currency(){
		return '$';
	}
	public static function frontendPrice($price){
		return ($price)? self::currency().''.$price : 0;
	}	
	public static function totalCartPrice($currency = true){
		$price = 0;
		$cart = session()->get('cart');
		if($cart){
			foreach ($cart as $item) {
				$price += $item['price'] * $item['quantity'];
			}
		}
		return ($currency)? self::frontendPrice($price) : $price;
	}
	public static function totalCartItem(){
		$total = 0;
		$cart = session()->get('cart');
		if($cart){
			foreach ($cart as $item) {
				$total += $item['quantity'];
			}
		}
		return $total;
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
	//price 	- offer_price
	public static function frontendItemPrice($item, $option = 'price'){
		$price = ($item->price)? $item->price : $item->sell_price;
		$original = ($item->price && $item->sell_price)? $item->sell_price : '';
		return ($option == 'original')? self::frontendPrice($original) : self::frontendPrice($price);
	}




	//Status label
	public static function getLabelByStatus($status, $tag = 'label'){
		switch ($status) {
			case 'pending':
			case 'unpaid':
			case 'due':
				return '<span class="'.$tag.' '.$tag.'-danger">'.ucfirst($status).'</span>';
				break;
			case 'processing':
				return '<span class="'.$tag.' '.$tag.'-primary">'.ucfirst($status).'</span>';
				break;
			case 'paid':
			case 'completed':
				return '<span class="'.$tag.' '.$tag.'-success">'.ucfirst($status).'</span>';
				break;
			case 'decline':
				return '<span class="'.$tag.' '.$tag.'-info">'.ucfirst($status).'</span>';
				break;
			default:
				return '<span class="'.$tag.' '.$tag.'-default">'.ucfirst($status).'</span>';
				break;
		}
	}

}
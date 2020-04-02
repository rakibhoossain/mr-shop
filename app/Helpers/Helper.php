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

	public static function currency(){
		return '$';
	}
	public static function frontendPrice($price){
		return ($price)? self::currency().''.$price : '';
	}	
	public static function totalCartPrice(){
		$price = 0;
		$cart = session()->get('cart');
		if($cart){
			foreach ($cart as $item) {
				$price += $item['price'] * $item['quantity'];
			}
		}
		return self::frontendPrice($price);
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
	public static function frontendItemPrice($item, $option = 'price'){
		$price = ($item->price)? $item->price : $item->sell_price;
		$original = ($item->price && $item->sell_price)? $item->sell_price : '';
		return ($option == 'original')? self::frontendPrice($original) : self::frontendPrice($price);
	}




	//Status label
	public static function getLabelByStatus($status){
		switch ($status) {
			case 'pending':
			case 'unpaid':
			case 'due':
				return '<span class="label label-danger">'.ucfirst($status).'</span>';
				break;
			case 'processing':
				return '<span class="label label-primary">'.ucfirst($status).'</span>';
				break;
			case 'paid':
			case 'completed':
				return '<span class="label label-success">'.ucfirst($status).'</span>';
				break;
			case 'decline':
				return '<span class="label label-info">'.ucfirst($status).'</span>';
				break;
			default:
				return '<span class="label label-default">'.ucfirst($status).'</span>';
				break;
		}
	}

}
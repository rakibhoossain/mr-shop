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

}
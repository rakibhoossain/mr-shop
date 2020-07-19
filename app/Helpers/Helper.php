<?php
namespace App\Helpers;
use App\Product;

class Helper{
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
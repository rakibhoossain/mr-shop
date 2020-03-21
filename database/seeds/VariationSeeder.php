<?php

use Illuminate\Database\Seeder;
use App\Variation;
// use App\VariationValue;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variations = array(
	  		array('slug' => 'Size', 'name' => 'Size'),
	  		array('slug' => 'color', 'name' => 'Color')
		);
		Variation::insert($variations);
        // DB::table('variations')->insert($variations);

        $sizes = array(
	  		array('name' => 'M'),
	  		array('name' => 'S'),
	  		array('name' => 'L'),
	  		array('name' => 'XL')
		);
        $colors = array(
	  		array('name' => 'Red',	'data' => '#ff0000', 'type' => 'color'),
	  		array('name' => 'Blue',	'data' => '#100de4', 'type' => 'color'),
	  		array('name' => 'Black','data' => '#171717', 'type' => 'color'),
	  		array('name' => 'Pink',	'data' => '#7d4aab', 'type' => 'color'),
		);
        foreach(Variation::get() as $variant){
        	if ($variant->name == 'Color') {
        		$variant->values()->createMany($colors);
        	}else{
        		$variant->values()->createMany($sizes);
        	}
        }
    }
}

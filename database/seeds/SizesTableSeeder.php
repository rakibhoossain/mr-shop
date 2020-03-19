<?php

use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = array(
	  		array('slug' => 'm', 'name' => 'M'),
	  		array('slug' => 's', 'name' => 'S'),
	  		array('slug' => 'l', 'name' => 'L'),
	  		array('slug' => 'xl', 'name' => 'XL')
		);
        DB::table('sizes')->insert($sizes);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    
	/**
     * @var array
     */
    protected $shipping_methods = [
    	[
    		'name' 			=> 'Free Delivary',
    		'price' 		=> 0,
    		'description' 	=> 'Free delivary goes delay!',
    	],	
    	[
    		'name' 			=> 'Normal Delivary',
    		'price' 		=> 60,
    		'description' 	=> 'Normal delivary takes 6-10 days!',
    	],
    	[
    		'name' 			=> 'Fast Delivary',
    		'price' 		=> 100,
    		'description' 	=> 'Normal delivary takes 3-7 days!',
    	],
    	[
    		'name' 			=> 'Express Delivary',
    		'price' 		=> 150,
    		'description' 	=> 'Normal delivary takes 1-2 days!',
    		'free_level' 	=> 1500
    	]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->shipping_methods as $k => $item) {
        	$result = ShippingMethod::create($item);
        	if (!$result) {
	           	$this->command->info("Insert failed at $k.");
	            return;
            }
        }
        $this->command->info('Shipping Methods Inserted Successfully!');
    }
}
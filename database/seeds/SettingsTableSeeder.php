<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

	/**
     * @var array
     */
    protected $settings = [
    	'general' => [
			[
	            'key'                       =>  'site_name',
	            'value'                     =>  'Mr. Shop',
	        ],
	        [
	            'key'                       =>  'site_title',
	            'value'                     =>  'E-Commerce',
	        ],
	        [
	            'key'                       =>  'default_email_address',
	            'value'                     =>  'admin@mail.com',
	        ],
	        [
	            'key'                       =>  'site_logo',
	            'value'                     =>  '',
	            'type'						=> 	'logo',
	        ],
	        [
	            'key'                       =>  'site_favicon',
	            'value'                     =>  '',
	            'type'						=> 	'favicon',
	        ],
	        [
	            'key'                       =>  'footer_copyright_text',
	            'value'                     =>  'Develop by Rakib Hossain',
	            'type'						=> 	'wysiwyg',
	        ],
    	],
    	'shop' => [
    		[
	            'key'                       =>  'currency_code',
	            'value'                     =>  'BDT',
	        ],
	        [
	            'key'                       =>  'currency_symbol',
	            'value'                     =>  '৳',
	        ],
	        [
	            'key'                       =>  'stripe_payment_method',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'stripe_key',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'stripe_secret_key',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'paypal_payment_method',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'paypal_client_id',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'paypal_secret_id',
	            'value'                     =>  '',
	        ],
    	],
    	'seo' => [
	        [
	            'key'                       =>  'seo_meta_title',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'seo_meta_description',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'social_facebook',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'social_twitter',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'social_instagram',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'social_linkedin',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'google_analytics',
	            'value'                     =>  '',
	        ],
	        [
	            'key'                       =>  'facebook_pixels',
	            'value'                     =>  '',
	        ],
    	]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		foreach ($this->settings as $group => $values)
        {
        	foreach ($values as $value) {
        		$value['group'] = $group;
        		$result = Setting::create($value);
        		if (!$result) {
	                $this->command->info("Insert failed at $group.");
	                return;
            	}
        	}
        }
        $this->command->info('Settings Inserted Successfully!');
    }
}

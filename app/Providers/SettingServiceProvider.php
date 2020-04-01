<?php

namespace App\Providers;

use Config;
use Cache;
use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('settings', function ($app) {
            return new Setting();
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Setting', Setting::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // only use the Settings package if the Settings table is present in the database
        if (!\App::runningInConsole() && count(Schema::getColumnListing('settings'))) {

            $settings = Cache::rememberForever('settings', function(){
               return Setting::pluck('value', 'key');
            });
            
            foreach ($settings as $key => $value)
            {
                Config::set('settings.'.$key, $value);
            }
        }
    }
}

<?php

namespace App;

use Config;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    /**
	 * @param $key
	 */
	public static function get($key)
	{
	    $setting = new self();
	    $entry = $setting->where('key', $key)->first();
	    if (!$entry) {
	        return;
	    }
	    return $entry->value;
	}

	/**
	 * @param $key
	 * @param null $value
	 * @return bool
	 */
	public static function set($key, $value = null)
	{
	    $setting = new self();
	    $entry = $setting->where('key', $key)->firstOrFail();
	    $entry->value = $value;
	    $entry->saveOrFail();
	    Cache::forget('settings');
	    Config::set('key', $value);
	    if (Config::get($key) == $value) {
	        return true;
	    }
	    return false;
	}
}

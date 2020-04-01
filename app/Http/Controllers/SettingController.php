<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Storage;
use Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting_groups = Setting::all()->groupBy('group');
        return view('dashboard.setting.index', compact('setting_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keys = $request->except(['_token', 'site_logo', 'site_favicon']);

        if($request->site_logo){
            $keys['site_logo'] = $this->uploadSettingImage($request->site_logo, config('settings.site_logo'));
        }
        if($request->site_favicon){
            $keys['site_favicon'] = $this->uploadSettingImage($request->site_favicon, config('settings.site_favicon'));
        }

        foreach ($keys as $key => $value)
        {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Settings update successfully!');
    }
    
    private function uploadSettingImage($new_img, $old_img)
    {
        if (preg_match('/data:image/', $new_img)){
            list($type, $new_img) = explode(';', $new_img);
            list(, $new_img)      = explode(',', $new_img);
            $data = base64_decode($new_img);
            $location = 'site/'.md5(microtime()).'.jpg';
            Storage::disk('public')->put($location, $data);

            $old = Str::replaceFirst('storage/', '', $old_img);
            Storage::disk('public')->delete($old);

            return 'storage/'.$location;
        }else{
            return ($new_img == 'del')? null : $old_img;
        }
    }
}

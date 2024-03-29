<?php
/**
 * Brain Train - Find the job you love!
 * Copyright (c) Brain Train Kenya. All Rights Reserved
 *
 * Website: http://www.braintrainke.com
 *
 * CODED WITH LOVE
 * ---------------
 * 	@author : Wanekeya Sam
 *  Title   : Full-stack Developer
 * 	created	: 02 September, 2017
 *	version : 1.0
 * 	website : https://www.wanekeyasam.co.ke
 *	Email   : contact@wanekeyasam.co.ke
 */

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS protocol
        $this->forceHttps();
    
        // Create setting config var for the default language
        $this->getDefaultLanguage();
    
        // Create config vars for settings table
        $this->createConfigVarForSettings();
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    // Force HTTPS protocol
    private function forceHttps()
    {
        if (config('larapen.core.force_https') == true) {
            URL::forceSchema('https');
        }
    }
    
    // Create setting config var for the default language
    private function getDefaultLanguage()
    {
        try {
            $defaultLang = Language::where('default', 1)->first();
            if (!empty($defaultLang)) {
                Config::set('applang', $defaultLang->toArray());
            } else {
                Config::set('applang.abbr', config('app.locale'));
            }
        } catch (\Exception $e) {
            Config::set('applang.abbr', config('app.locale'));
        }
    }
    
    // Create config vars for settings table
    private function createConfigVarForSettings()
    {
        // Check DB connection and catch it
        try {
            // Get all settings from the database
            $settings = Setting::where('active', 1)->get();
            
            // Bind all settings to the Laravel config, so you can call them like
            if ($settings->count() > 0) {
                foreach ($settings as $key => $setting) {
                    if (!empty($setting->value)) {
                        Config::set('settings.' . $setting->key, $setting->value);
                    }
                }
            }
        } catch (\Exception $e) {
            // Notify DB error
            Config::set('settings.error', true);
        }
    }
}

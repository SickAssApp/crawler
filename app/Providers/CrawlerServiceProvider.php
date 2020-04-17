<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\CrawlFunc;

class CrawlerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }    

    // public function crawlPageNCreateData()
    // {
    //     echo Config::get('siteConfig.crawlUrl');
    // }



    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\CrawlFunc',function($app){
            return new CrawlFunc();
        });
    }
}

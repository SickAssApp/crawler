<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

use App\Library\Services\CrawlFunc;

class crawlPerHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl target website every hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CrawlFunc $CrawlFunc)
    {
        $astroAry = array();
        $astroAry = $CrawlFunc->crawlAstroURL(Config::get('siteConfig.crawlUrl'));
        
        // var_dump($astroAry);
        foreach($astroAry as $k => $v){            
            $resAry = $CrawlFunc->crawlAstroInfo($v, '.TODAY_CONTENT > p');            
            $CrawlFunc->analizeNSave($resAry);
        }
    }
}

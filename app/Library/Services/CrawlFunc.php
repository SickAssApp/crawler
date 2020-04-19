<?php
namespace App\Library\Services;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Exception;

use App\Page;

  
class CrawlFunc
{
    public function __construct()
    {
      $this->client = new Client([
              'timeout'   => 10,
              'verify'    => false
          ]);
    }

    /**
       * Get the URL of all the astro.
       *
       * @return array
       */
    public function crawlAstroURL($url)
    {      
      try {          
          $response = $this->client->get($url);
          // get content and pass to the crawler
          $content = $response->getBody()->getContents();
          $crawler = new Crawler( $content );
          
          $_this = $this;
          $data = $crawler->filter('li[class*="STAR_"]')
                          ->each(function (Crawler $node, $i) use($_this) {
                            return $_this->getAstroInfo($node);                                                        
                          }
                      );
          return $data;
      } catch ( Exception $e ) {
          echo $e->getMessage();
      }

    }

    
    /**
       * Get astro info.
       *
       * @return array
       */
    public function crawlAstroInfo($url, $needle)
    {
      try {          
          $response = $this->client->get($url);
          // Get the redirect javascript.
          $redirectData = $response->getBody()->getContents();
          
          // Get the actual link
          $actualLink = $this->getActualLink($redirectData);

          // Get actual data
          $response = $this->client->get($actualLink);                    
          $content = $response->getBody()->getContents();
          $crawler = new Crawler( $content );          
          $data = $crawler->filter($needle)->each(function($p){
            return trim($p->text());
          });
          
          return $data;
      } catch ( Exception $e ) {
          echo $e->getMessage();
      }
    }

    /**
       * Analize the content and save it to database.
       *
       * 
       */
    public function analizeNSave($data,$astroName)
    {
      
      $page = new Page;
      $page->astroName  =   $astroName;
      $page->totalScore =   $this->getStarCount($data[0]);
      $page->totalDesc  =   $data[1];
      $page->loveScore  =   $this->getStarCount($data[2]);
      $page->loveDesc   =   $data[3];
      $page->buissScore =   $this->getStarCount($data[4]);
      $page->buissDesc  =   $data[5];
      $page->finScore   =   $this->getStarCount($data[6]);
      $page->finDesc    =   $data[7];
    // Not using this field but create it as a status.
      $page->isCrawled  =   1;

      $page->save();
    }
    
    // Find star count
    private function getStarCount($data)
    {
      $resStr = str_replace(['☆','：'], '', $data);
      $resStr = preg_replace("/[\x{4e00}-\x{9fa5}]+/u", '', $resStr);
      
      return mb_strlen($resStr, "UTF-8");
    }

    // Filter the hyperlink context.
    private function getAstroInfo($node)
    {
      $resAry = array(
        'url'   => $node->filter('a')->attr('href'),
        'title' => $node->filter('a')->attr('title'),
      );
      
      return $resAry;
    }

    // Get actual link
    private function getActualLink($data)
    {
      preg_match('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s',$data,$match);
      return $match[0];
    }
}
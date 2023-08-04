<?php

namespace App\Console\Commands\Crawlers;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

use App\Models\Idlix as TableIdilix;

class Idlix extends Command
{
    private $cached_time = 3600; //1 hour;

    private $cache;

    private static $host = "https://tv.idlixprime.com/";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:idlix {type?} {--query=} {--page=} {--cache=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawling movies from idlix website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->cache = (bool)$this->option('cache');

        $type = $this->argument('type');

        switch($type){
            case 'wp' : 
                $this->getWP();
                break;
            case 'movies':
                $this->getMovies($this->option('page'));
                break;
            case 'search':
                $this->search($this->option('query'));
                break;
            default:
                $this->getWP();
                break;

        }

        
    }

    private function search($q)
    {
        $path = "search/" . $q;
        $search = $this->rememberHtml($q, $path);

        $result = $search->filter('#contenedor > div.module > div.content.rigth.csearch > div > div.no-result.animation-2');

        $text = $result->filter('h2')->text('');

        if(!empty($text)) return $this->warn($text);

        $movies = $search->filter('div.result-item article')->each(function(Crawler $movieCrawler){
            $title = $movieCrawler->filter('div.title a')->text('');
            $year = $movieCrawler->filter('div.meta span.year')->text('');
            $rating = $movieCrawler->filter('div.meta span.rating')->text('');
            $image = $movieCrawler->filter('div.thumbnail img')->attr('src');
            $description = $movieCrawler->filter('div.contenido p')->text('');
            $type = $movieCrawler->filter('div.image > div > a > span')->text('');

            $moviesData = [
                'title' => $title,
                'type' => $type,
                'year' => $year,
                'rating' => $rating,
                'image' => $image,
                'description' => $description,
            ];

            return $moviesData;
        });

        print_r($movies);

    }

    private function getWP()
    {
        $wp = $this->rememberHtml('wp');

        $wp_featureds = $this->featureds($wp);

        $result = ['featured' => $wp_featureds];

        print_r($result);
    }

    private function getMovies($page = 0)
    {
        $path = empty($page) ? "movie" : "movie/page/" . (int) $page;

        $movies_page = $this->rememberHtml($path , $path);

        $mp_featureds = $this->featureds($movies_page);

        $mp_movies = $this->allMovies($movies_page);

        print_r([
            'featureds' => $mp_featureds,
            'movies' => $mp_movies
        ]);

    }

    private function allMovies(Crawler $crawler)
    {
        $crawler = $crawler->filter('#archive-content');
        return $this->byType($crawler, 'movies');
    }

    private function featureds(Crawler $crawler)
    {
        $featureds = $crawler->filter('#contenedor > div.module > div > div.items.featured');

        $movies = $this->byType($featureds, 'movies');

        $tvshows = $this->byType($featureds, 'tvshows');

        return array_merge($movies, $tvshows);
    }

    private function byType(Crawler $crawler, $type)
    {
        return $crawler->filter('article.item.'.$type)
            ->each(function(Crawler $article) use(&$results, $type){


                $title = $article->filter('h3 a')->text();
                $link = $article->filter('h3 a')->attr('href');
                $rating = $article->filter('div.rating')->text();
                $quality = $article->filter('div.mepo > span')->text('WEBDL');
                $year = $article->filter('div.data > span')->text();
                $image = $article->filter('img')->attr('src');

                $results = [
                    'title' => $title,
                    'type' => $type,
                    'link' => $link,
                    'rating' => $rating,
                    'quality' => $quality,
                    'year' => $year,
                    'image' => $image
                ]; 

                return $results;
            });
    }

    private function req($url)
    {
        try{
            $client = new Client;

            $headers = [
                'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36',
            ];

            $request = new Request('GET', $url, $headers);

            $async = $client->sendAsync($request)->wait();

            $result = $async->getBody()->getContents();

            return $result;

        }catch(\GuzzleHttp\Exception\ClientException $e){

            return $e->getMessage();
        }
    }

    private function rememberHtml($key, $path = '/')
    {
        if($this->cache){
            $html = Cache::remember($key, $this->cached_time, fn() => 
                $this->req(self::$host . $path)
            );
        }else{
            $html = $this->req(self::$host . $path);
        }

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        return $crawler;
    }
}

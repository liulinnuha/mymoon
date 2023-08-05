<?php

namespace App\Console\Commands\Kemdikbud;

use Illuminate\Console\Command;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class Find extends Command
{

    private static $base_url = 'https://api-frontend.kemdikbud.go.id/';

    private $query;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kemdikbud:find 
                            {--pt= : Nama PT atau Nama Universitasnya}
                            {--np= : Nama Prodi}
                            {--nm= : Nama Mahasiswa}
                            {--nd= : Nama Dosen}
                            {--nim= : Nomor Induk Mahasiswa}
                            {--nidn= : nidn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Student On db kemdikbud';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pt = $this->option('pt') ? $this->option('pt') . " " : '';
        $np = $this->option('np') ? $this->option('np') . " " : '';
        $nm = $this->option('nm') ? $this->option('nm') . " " : '';
        $nd = $this->option('nd') ? $this->option('nd') . " " : '';
        $nim = $this->option('nim') ? $this->option('nim') . " " : '';
        $nidn = $this->option('nidn') ? $this->option('nidn') . " " : '';

        $this->query = $pt . $np . $nm . $nd . $nim . $nidn;

        if(empty($this->query)){
            $this->error("Please input one option !");
            return Command::FAILURE;
        }

        $check = $this->check();

        $this->printResult($check, 'mahasiswa');
        $this->printResult($check, 'dosen');
        $this->printResult($check, 'prodi');
        $this->printResult($check, 'pt');
    }

    private function printResult($data, $key)
    {
        if(!Arr::exists($data, $key)) return $this->warn($key . ' Not Found !');

        $this->warn("=============================[$key]================================================");
        foreach($data[$key] as $result){

            $this->info($result['text'] . "\t=>\t" . $result['website-link']);
        }

    }

    private function check()
    {
        $result = [];
        foreach(['hit_mhs/', 'hit/'] as $path){
            $search = $this->req(self::$base_url . $path . $this->query);

            array_push($result, $search);
        }

        return Arr::collapse(array_filter($result));
    }

    private function req($url)
    {
        $client = new Client();
        $request = new Request('GET', $url);
        $async = $client->sendAsync($request)->wait();
        
        $contents = $async->getBody()->getContents();

        return json_decode($contents, true);
    }
}

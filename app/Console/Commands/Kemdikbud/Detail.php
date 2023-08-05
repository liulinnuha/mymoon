<?php

namespace App\Console\Commands\Kemdikbud;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class Detail extends Command
{
    private static $base_url = 'https://api-frontend.kemdikbud.go.id/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kemdikbud:detail
                            {link}
                            {--type=mhs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Detail Dosen atau mahasiswa menggunakan link yg di dapat dari kemdikbud:find';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $link = $this->argument('link');
        $type = $this->option('type');

        if(!$link) return Command::FAILURE;

        $id = Str::afterLast($link,'/');

        $detail = $this->detail($id, $type);

        $this->printResult($detail);
    }

    private function printResult($data)
    {
        $this->warn("==============[Biodata Mahasiswa]============");

        foreach($data['dataumum'] as $key => $biodata)
        {
            $this->info("$key => $biodata");
        }

        $this->warn("==============[Riwayat Status Kuliah]==========");

        $this->info("Semester\t|Status\t|SKS");
        $this->warn("-----------------------------------------------");

        foreach($data["datastatuskuliah"] as $idx => $value){
            $semester = $this->getSmt($value);

            $this->info("$semester\t|".$value['nm_stat_mhs']."\t|".$value['sks_smt']);
        }

        $this->warn("==============[Riwayat Studi]==================");

        $this->info("Semester\t|Kode Mata Kuliah\t|Mata Kuliah\t|SKS");
        $this->warn("-----------------------------------------------------");

        foreach($data['datastudi'] as $std)
        {
            $semester = $this->getSmt($std);
            $this->info("$semester\t|".$std['kode_mk']."\t|".$std['nm_mk']."\t|". $std['sks_mk']);
        }
    }

    private function getSmt($array)
    {
        $year = substr($array['id_smt'], 0, 4);
        $ganjilGenap = substr($array['id_smt'], -1);
        $semester = ($ganjilGenap === '1') ? 'ganjil' : 'genap';

        return $semester . " " . $year;
    }

    private function detail($id, $type)
    {
        switch($type){
            case 'mhs':
                $url = self::$base_url .'detail_mhs/'.$id;
                break;
            case 'dosen':
                $url = self::$base_url .'detail_dosen/'.$id;
                break;

            default:
                $url = self::$base_url .'detail_mhs/'.$id;
                break;
        }

        return $this->req($url);


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

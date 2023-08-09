<?php
use Carbon\Carbon;


if(!function_exists('getZodiacSign')){
	function getZodiacSign($date) {
	    $tanggal = intval(date('d', strtotime($date)));
	    $bulan = intval(date('m', strtotime($date)));

	    $zodiacSigns = [
	        ["name" => "Capricorn", "start_date" => "01-01", "end_date" => "01-19"],
	        ["name" => "Aquarius", "start_date" => "01-20", "end_date" => "02-18"],
	        ["name" => "Pisces", "start_date" => "02-19", "end_date" => "03-20"],
	        ["name" => "Aries", "start_date" => "03-21", "end_date" => "04-19"],
	        ["name" => "Taurus", "start_date" => "04-20", "end_date" => "05-20"],
	        ["name" => "Gemini", "start_date" => "05-21", "end_date" => "06-20"],
	        ["name" => "Cancer", "start_date" => "06-21", "end_date" => "07-22"],
	        ["name" => "Leo", "start_date" => "07-23", "end_date" => "08-22"],
	        ["name" => "Virgo", "start_date" => "08-23", "end_date" => "09-22"],
	        ["name" => "Libra", "start_date" => "09-23", "end_date" => "10-22"],
	        ["name" => "Scorpio", "start_date" => "10-23", "end_date" => "11-21"],
	        ["name" => "Sagittarius", "start_date" => "11-22", "end_date" => "12-21"],
	        ["name" => "Capricorn", "start_date" => "12-22", "end_date" => "12-31"]
	    ];

	    foreach ($zodiacSigns as $sign) {
	        $start_date = strtotime($sign['start_date']);
	        $end_date = strtotime($sign['end_date']);

	        $date_to_check = strtotime("$bulan-$tanggal");

	        if (($date_to_check >= $start_date) && ($date_to_check <= $end_date)) {
	            return $sign['name'];
	        }
	    }

	    return "Unknown";
	}
}

if(!function_exists('getDayPasaran')){
	function getDayPasaran($date) {
	    
    	list($day, $month, $year) = explode('-', $date);
	    $p = 0;
	    for ($m = 1; $m < $month; $m++) {
	        $daysInMonth = Carbon::create($year, $m, 1)->daysInMonth;
	        $p += $daysInMonth;
	    }
	    $p += $day;

	    // Hitung nilai q
	    $q = floor(($year - 1) / 4);

	    // Hitung nilai x dan y
	    $x = $p + $q;
	    $y = $p + $q + $year;

	    // Tentukan pasaran dan hari lahir
	    $pasaranList = ['Legi', 'Pahing', 'Pon', 'Wage', 'Kliwon'];
	    $dayList = ['Jumat', 'Sabtu', 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis'];

	    $pasaranIndex = $x % count($pasaranList);
	    $dayIndex = $y % count($dayList);

	    $validPasaran = $pasaranList[$pasaranIndex];
	    $validDay = $dayList[$dayIndex];

	    return $validDay . ' ' .$validPasaran;
	}
}

if(!function_exists('getAge')){
	function getAge($date) {
	    $tanggal_lahir_obj = Carbon::parse($date);
	    $now = Carbon::now();
	    $umur = $now->diffInYears($tanggal_lahir_obj);

	    return $umur;
	}
}

if(!function_exists('getNextBday')){
	function getNextBday($date){
		$tanggal_lahir_obj = Carbon::parse($date);
                
        $tanggal_sekarang_obj = Carbon::now();


        $tanggal_lahir_tahun_ini = $tanggal_lahir_obj->copy()->setYear($tanggal_sekarang_obj->year);

        if ($tanggal_lahir_tahun_ini < $tanggal_sekarang_obj) {
            $tanggal_lahir_tahun_ini->addYear();
        }
        $selisih = $tanggal_lahir_tahun_ini->diff($tanggal_sekarang_obj);


        return $selisih->format("%m bulan, %d hari, %h jam, %i menit, %s detik");
	}
}

if(!function_exists('getDayBday')){
	function getDayBday($date){
		Carbon::setLocale('id');

		$carbonDate = Carbon::createFromFormat('d-m-Y', $date, 'Asia/Jakarta');

		return $carbonDate->isoFormat('dddd');
	}
}

if(!function_exists('getNeptu')){
	function getNeptu($string)
	{
		$neptuArray = [
		    'Senin' => 5,
		    'Selasa' => 4,
		    'Rabu' => 3,
		    'Kamis' => 7,
		    'Jumat' => 8,
		    'Sabtu' => 6,
		    'Minggu' => 9,
		    'Legi' => 5,
		    'Pahing' => 9,
		    'Pon' => 7,
		    'Wage' => 4
		];

		return $neptuArray[$string];
	}
}








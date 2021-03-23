<?php

use Illuminate\Database\Seeder;

class LogisticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        \App\Models\Logistics::create([
            'url'=>'http://logisticsqa.ericuae.com/api/service/getQuote/',
            'token'=>'5nqUrVsL7818QDVRQEsQC2ERnKxOd5ESNLuzgMIv3wk=',
            'method'=>'getQuote',
        ]);
        \App\Models\Logistics::create([
            'url'=>'http://logisticsqa.ericuae.com/api/service/bookservice/',
            'token'=>'5nqUrVsL7818QDVRQEsQC2ERnKxOd5ESNLuzgMIv3wk=',
            'method'=>'bookservice',
        ]);
    }
}

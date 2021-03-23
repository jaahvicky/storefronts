<?php

use Illuminate\Database\Seeder;

class StoreTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_types')->truncate();
        DB::table('store_types')->insert([
            ['type' => 'Vehicles', 'slug'=>'vehicles','amount'=> 50],
            ['type' => 'Property', 'slug'=>'property','amount'=> 50],
            ['type' => 'Mobile &amp; Electronics', 'slug'=>'mobile-electronics','amount'=> 10],
            ['type' => 'Farming &amp; Industrial', 'slug'=>'farming-industrial','amount'=> 10],
            ['type' => 'Fashion &amp; Beauty', 'slug'=>'fashion-beauty','amount'=> 10],
            ['type' => 'Home, Garden &amp; Tools', 'slug'=>'home-garden-tools','amount'=> 10],
            ['type' => 'Jobs', 'slug'=>'jobs','amount'=> 10],
            ['type' => 'Hobbies &amp; Interests', 'slug'=>'hobbies-interests','amount'=> 10],
            ['type' => 'Kids & Baby', 'slug'=>'kids-baby','amount'=> 10],
            ['type' => 'Pets', 'slug'=>'pets','amount'=> 10],
            ['type' => 'Sports &amp; Outdoors', 'slug'=>'sports-outdoors','amount'=> 10],
            ['type' => 'Services', 'slug'=>'services','amount'=> 10] 
        ]); 
    }
}

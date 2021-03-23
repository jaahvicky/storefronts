<?php

use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        \App\Models\StoreDeliveryMethod::create([
            'method' => 'Econet Logistics'
        ]);
        \App\Models\StoreDeliveryMethod::create([
            'method' => 'Arrange with Seller'
        ]);
        \App\Models\StoreDeliveryMethod::create([ 
            'method' => 'Collect in Store'
        ]);
    } 
}

<?php

use Illuminate\Database\Seeder;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (Schema::hasTable('delivery_status'))
        {   
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('delivery_status')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::table('delivery_status')->insert([
                ['status' => 'Pending'],
                ['status' => 'Processing'],
                ['status' => 'Completed'],
                ['status' => 'Dispatched'],
                ['status' => 'Ready For Collection'],
                ['status' => 'Cancelled']
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('payment_status'))
        {
            DB::table('payment_status')->insert([
                ['status' => 'Pending'],
                ['status' => 'Paid'],
                ['status' => 'Cancelled']
            ]);
            
        }

        
    }
}

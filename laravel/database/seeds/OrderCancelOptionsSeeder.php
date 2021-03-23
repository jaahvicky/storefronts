<?php

use Illuminate\Database\Seeder;

class OrderCancelOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('order_cancel_options'))
        {
            DB::table('order_cancel_options')->insert([
                ['options' => 'I am out of stock'],
                ['method' => 'I do not wish to fulfill this order'],
                ['method' => 'Customer did not collect'],
                ['method' => 'Unable to deliver the order'],
                ['method' => 'Other']
            ]);
        }
    }
}

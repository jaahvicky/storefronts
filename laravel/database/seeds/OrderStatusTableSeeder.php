<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->insert([[
        	'status' => 'Pending'
        ],
        [
        	'status' => 'On Hold'
        ],
        [
        	'status' => 'Cancelled'
        ],
        [
        	'status' => 'Complete'
        ]]);
    }
}

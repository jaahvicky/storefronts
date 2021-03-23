<?php

use Illuminate\Database\Seeder;

class StoreStatusTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_status_types')->insert([

            ['id' => 1, 'label' => 'Pending', 'tag' => 'pending-open'],
            ['id' => 2, 'label' => 'Pending', 'tag' => 'pending-reopen'],
            ['id' => 3, 'label' => 'Approved', 'tag' => 'approved'],
            ['id' => 4, 'label' => 'Rejected', 'tag' => 'rejected'],
            ['id' => 5, 'label' => 'Closed', 'tag' => 'closed'],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\User')->create([
            'username' => 'benjamin',
            'email' => 'agalagade@methys.com',
            'password' => bcrypt('123456')
        ]);
        
        factory('App\Models\User')->create([
            'username' => 'Methys',
            'email' => 'test@cytrus.biz',
            'password' => bcrypt('123456')
        ]);
        
        factory('App\Models\User')->create([
            'username' => 'Econet',
            'email' => 'cmocke@econetwireless.com',
            'password' => bcrypt('123456')
        ]);

        factory('App\Models\User')->create([
            'username' => 'storemod',
            'email' => 'storemod@test.biz',
            'password' => bcrypt('123456')
        ]);

        factory('App\Models\User')->create([
            'username' => 'productmod',
            'email' => 'productmod@test.biz',
            'password' => bcrypt('123456')
        ]);
    }
}

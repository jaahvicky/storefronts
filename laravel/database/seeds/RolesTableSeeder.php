<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\Role')->create([
            'name' => 'superadmin',
            'label' => 'Super Admin'
        ]);
        
        factory('App\Models\Role')->create([
            'name' => 'storeowner',
            'label' => 'Store Owner'
        ]);

        factory('App\Models\Role')->create([
            'name'    => 'storemoderator',
            'label'   => 'Store Moderator'
        ]);

        factory('App\Models\Role')->create([
            'name'  => 'productmoderator',
            'label' => 'Product Moderator'
        ]);

        $this->assignRolesToUsers();
    }
    
    private function assignRolesToUsers() {
        
        $methys   = App\Models\User::where('username', 'Methys')->first();
        $econet   = App\Models\User::where('username', 'Econet')->first();
        $benjamin = App\Models\User::where('username', 'benjamin')->first();
        $storemod = App\Models\User::where('username', 'storemod')->first();
        $productmod = App\Models\User::where('username', 'productmod')->first();

        
        $methys->assignRole('superadmin');
        $econet->assignRole('superadmin');
        $benjamin->assignRole('storeowner');
        $storemod->assignRole('storemoderator');
        $productmod->assignRole('productmoderator');
    }
}

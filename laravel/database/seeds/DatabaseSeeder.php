<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    
    protected $toTruncate = [
        'role_user', 
        'permission_role', 
        'users', 
        'roles', 
        'permissions', 
        'attribute_category',
        'categories', 
        'attribute_values',
        'attributes'
        // 'logistics'
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        foreach($this->toTruncate As $table) {
            DB::table($table)->truncate();
        }
        
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(AttributesSeeder::class);
        $this->call(ProductLookupTableSeeder::class);
        $this->call(OwnaiTableSeeder::class);
        $this->call(StoreStatusTypes::class);
        $this->call(StoreTypesTableSeeder::class);
        $this->call(DeliveryStatusSeeder::class);
        $this->call(DeliveryMethodSeeder::class);
        $this->call(CityAndSuburbTableSeeder::class);
        $this->call(StoreDeliveryMethodsSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(LogisticsTableSeeder::class);
        $this->call(OrderCancelOptionsSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

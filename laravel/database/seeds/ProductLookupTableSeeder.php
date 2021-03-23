<?php

use Illuminate\Database\Seeder;

class ProductLookupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        
      DB::table('product_status_types')->insert([
            ['id'=>1, 'name' => 'Draft'],
            ['id'=>2, 'name' => 'Visible'],
            ['id'=>3, 'name' => 'Hidden']
        ]);
        
       DB::table('product_types')->insert([
            ['id'=>1,'name' => 'Simple'],
            ['id'=>2,'name' => 'Variable']
        ]);

    }
}

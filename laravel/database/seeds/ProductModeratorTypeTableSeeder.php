<?php

use Illuminate\Database\Seeder;

class ProductModeratorTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       DB::table('product_moderation_types')->truncate();
       DB::statement('SET FOREIGN_KEY_CHECKS=1;');
       DB::table('product_moderation_types')->insert([
            ['id'=>1, 'name' => 'Approved'],
            ['id'=>2, 'name' => 'Rejected']
        ]);
        
      
    }
}

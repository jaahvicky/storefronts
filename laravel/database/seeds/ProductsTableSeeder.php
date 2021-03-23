<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('products')->insert([[
	        'store_id' => 1,
			'title' => 'Obi Wan\'s Lightsaber 2',
			'description' => 'Replica of the lightsaber used by Obi Wan',
			'slug' => 'obi-wans-lightsaber-2',
			'price' => 5000,
			'currency_id' => 1,
			'product_status_id' => 2, //visible
			'product_type_id' => 2, //simple
			'category_id' => 153,
	        'product_moderation_type_id' => 2, //Approved
	    ],
	    [
			'store_id' => 1,
			'title' => 'Kung Pow DVD',
			'description' => 'Kung Pow DVD',
			'slug' => 'kung-pow',
			'price' => 8000,
			'currency_id' => 1,
			'product_status_id' => 2, //visible
			'product_type_id' => 2, //simple
			'category_id' => 153,
	        'product_moderation_type_id' => 2, //Approved
	    ]]
	    );
    }
}

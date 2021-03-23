<?php

use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_images')->insert([[
	        'product_id'		=> 1,
	        'filename'			=> 'product_sample_01.jpg',
	        'original_upload'   => 'product_sample_01.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 1,
	        'filename'			=> 'product_sample_02.jpg',
	        'original_upload'   => 'product_sample_02.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 1,
	        'filename'			=> 'product_sample_03.jpg',
	        'original_upload'   => 'product_sample_03.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 1,
	        'filename'			=> 'product_sample_04.jpg',
	        'original_upload'   => 'product_sample_04.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 2,
	        'filename'			=> 'product_sample_05.jpg',
	        'original_upload'   => 'product_sample_05.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 2,
	        'filename'			=> 'product_sample_06.jpg',
	        'original_upload'   => 'product_sample_06.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 2,
	        'filename'			=> 'product_sample_07.jpg',
	        'original_upload'   => 'product_sample_07.jpg',
	        'featured'			=> 0
	    ],
	    [
			'product_id'		=> 2,
	        'filename'			=> 'product_sample_08.jpg',
	        'original_upload'   => 'product_sample_08.jpg',
	        'featured'			=> 0
	    ]

	    ]);
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('product_contact_details', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->string('contact_name');
			$table->string('phone');
			$table->integer('city_id')->unsigned();
			$table->integer('suburb_id')->unsigned(); 
			$table->softDeletes();
            $table->timestamps();
			$table->foreign('product_id')->references('id')->on('products');
			$table->foreign('city_id')->references('id')->on('cities');
			$table->foreign('suburb_id')->references('id')->on('suburbs');
			

		});
		
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Schema::dropIfExists('product_contact_details');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}

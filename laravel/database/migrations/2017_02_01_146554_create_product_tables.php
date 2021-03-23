<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('products', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('store_id')->unsigned();
			$table->string('title');
			$table->string('description'); 
			$table->string('slug');
			$table->string('platform');
			 
			$table->float('price', 20, 2);
			$table->integer('currency_id')->unsigned(); 
			
			$table->integer('product_type_id')->unsigned();
			$table->integer('product_status_id')->unsigned();
			
			$table->integer('category_id')->unsigned();
			$table->integer('product_moderation_type_id')->unsigned()->nullable();
			$table->integer('category_custom_id')->unsigned()->nullable();
			
			$table->softDeletes();
            $table->timestamps();
			
			$table->foreign('product_type_id')->references('id')->on('product_types');
			$table->foreign('product_status_id')->references('id')->on('product_status_types');
			$table->foreign('store_id')->references('id')->on('stores');
			$table->foreign('category_id')->references('id')->on('categories');
			$table->foreign('category_custom_id')->references('id')->on('categories_customs');
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->foreign('product_moderation_type_id')->references('id')->on('product_moderation_types');

		});
		
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Schema::dropIfExists('products');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}

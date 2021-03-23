<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('order');
			
			$table->index('slug');
			$table->index('order');
			
			$table->timestamps();
			
			$table->foreign('parent_id')->references('id')->on('categories');
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Schema::dropIfExists('categories');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLookups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('product_status_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->softDeletes();
            $table->timestamps();
		});

	

		Schema::create('product_moderation_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->softDeletes();
            $table->timestamps();
		});

		Schema::create('product_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->softDeletes();
            $table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Schema::dropIfExists('product_types');
		Schema::dropIfExists('product_moderation_types');
		Schema::dropIfExists('product_status_types');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//Remove custom categories from products
		// Schema::table('products', function ($table) {
		// 	$table->dropForeign('products_category_custom_id_foreign');
		// 	$table->dropColumn('category_custom_id');
  //       });
		
		// //Drop custom categories table
  //       Schema::drop('categories_custom');
		
		// //Add fields to categories table
		// Schema::table('categories', function ($table) {
		// 	$table->integer('store_id')->unsigned()->nullable()->after('id');
		// 	$table->timestamp('deleted_at')->nullable()->after('order');
			
		// 	$table->foreign('store_id')->references('id')->on('stores');
  //       });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Recreate custom categories table
		// Schema::create('categories_custom', function (Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->integer('store_id')->unsigned();
			
		// 	$table->string('name');
		// 	$table->string('slug');
		// 	$table->integer('parent_id')->unsigned();
		// 	$table->integer('order');
			
		// 	$table->index('slug');
		// 	$table->index('order');
			
		// 	$table->softDeletes();
  //           $table->timestamps();
			
		// 	$table->foreign('store_id')->references('id')->on('stores');
		// 	$table->foreign('parent_id')->references('id')->on('categories');
		// });
		
		// //Remove fields from categories
		// Schema::table('categories', function ($table) {
		// 	$table->dropForeign('categories_store_id_foreign');
		// 	$table->dropColumn('store_id');
		// 	$table->dropColumn('deleted_at');
			
  //       });
		
		// Schema::table('products', function ($table) {
		// 	$table->integer('category_custom_id')->unsigned()->nullable();
		// 	$table->foreign('category_custom_id')->references('id')->on('categories_custom');
  //       });
    }
}

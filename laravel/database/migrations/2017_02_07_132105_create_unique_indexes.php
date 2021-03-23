<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function ($table) {
            $table->unique('slug');
        }); 
		
		    Schema::table('products', function ($table) {
            $table->unique(['slug', 'store_id']);
        }); 
		
		    Schema::table('categories_customs', function ($table) {
            $table->unique(['slug', 'store_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

  //       Schema::table('stores', function ($table) {
  //           $table->dropUnique('stores_slug_unique');
  //       }); 
		
		// Schema::table('products', function ($table) {
  //           $table->dropUnique('products_slug_store_id_unique');
  //       });
		
		// Schema::table('categories_custom', function ($table) {
  //           $table->dropUnique('categories_custom_slug_store_id_unique');
  //       });
    }
}

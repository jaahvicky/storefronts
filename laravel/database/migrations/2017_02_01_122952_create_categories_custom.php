<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/**********************************************
*
* table for third tie categories
*/
class CreateCategoriesCustom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('categories_customs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            
            $table->string('name');
            $table->string('slug');
            $table->integer('parent_id')->unsigned();
            $table->integer('order');
            
            $table->index('slug');
            $table->index('order');
            
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('parent_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('categories_customs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

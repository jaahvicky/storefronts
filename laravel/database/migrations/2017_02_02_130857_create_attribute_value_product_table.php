<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValueProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('attribute_value_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_value_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('value')->nullable();
            
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values');
            $table->foreign('product_id')->references('id')->on('products');

            $table->timestamps();
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
        Schema::dropIfExists('attribute_value_product');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

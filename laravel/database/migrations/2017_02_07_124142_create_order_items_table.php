<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('qty');
            $table->string('data');
            $table->integer('orders_id')->unsigned();
            $table->integer('products_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('orders_id')->references('id')->on('orders');
            $table->foreign('products_id')->references('id')->on('products');

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
         Schema::dropIfExists('order_items');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // order foreign key requires this table first
        Schema::create('delivery_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
        });

        Schema::create('orders', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            // Buyer
            $table->string('buyer_firstname');
            $table->string('buyer_lastname');
            $table->string('buyer_address');
            $table->string('buyer_email');
            $table->integer('buyer_phone');
            $table->integer('amount');
            $table->string('payment_status');
            $table->longText('response_data');
            $table->string('invoice_number');
            $table->integer('delivery_status_id')->unsigned();
            $table->string('order_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('delivery_status_id')->references('id')->on('delivery_status');


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
        Schema::dropIfExists('delivery_status');
        Schema::dropIfExists('orders');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

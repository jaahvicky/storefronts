<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_cancellations', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('order_cancellations_cancel_options_id')->unsigned(); // belongs to
            $table->integer('orders_id')->unsigned(); // belongs to
            $table->string('reason'); // set validation
            $table->timestamps();

            //$table->foreign('order_cancellations_cancel_options_id')->references('id')->on('order_cancellations_cancel_options');
            // rather leaving out orders as a foreign key in case orders are deleted
        });

        Schema::create('order_cancel_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('options');
            $table->timestamps();
        });

        Schema::create('order_cancellations_cancel_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_cancellations_id')->unsigned(); // belongs to
            $table->integer('order_cancel_options_id')->unsigned(); // belongs to
            $table->timestamps();

            //$table->foreign('order_cancellations_id')->references('id')->on('order_cancellations');
            //$table->foreign('order_cancel_options_id')->references('id')->on('order_cancel_options');
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
        Schema::dropIfExists('order_cancellations');
        Schema::dropIfExists('order_cancel_options');
        Schema::dropIfExists('order_cancellations_cancel_options');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

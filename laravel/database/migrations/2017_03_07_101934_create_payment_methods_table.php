<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('payment_methods'))
        // {
        //     Schema::create('payment_methods', function (Blueprint $table) {
        //         $table->increments('id');
        //         $table->string('method');
        //     });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payment_status');
    }
}

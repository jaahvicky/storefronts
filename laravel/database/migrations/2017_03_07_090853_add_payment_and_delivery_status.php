<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentAndDeliveryStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // //
        // if ( (Schema::hasTable('orders')) && (!Schema::hasColumn('orders', 'payment_status_id')) && (!Schema::hasColumn('orders', 'delivery_status_id')) )
        // {
        //     //
        //     Schema::table('orders', function($table)
        //     {
        //         $table->integer('payment_status_id')->unsigned();
        //         $table->integer('delivery_status_id')->unsigned();
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
        // //
        // if ( (Schema::hasTable('orders')) && (Schema::hasColumn('orders', 'payment_status_id')) && (Schema::hasColumn('orders', 'delivery_status_id')) ){

        //     Schema::table('orders', function($table)
        //     {
        //         $table->dropColumn(['payment_status_id', 'delivery_status_id']);
        //     });

        // }
        
    }
}

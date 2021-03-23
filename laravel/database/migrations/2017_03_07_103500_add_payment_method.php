<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentMethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // if ( (Schema::hasTable('orders')) && (!Schema::hasColumn('orders', 'payment_method_id')) )
        // {
        //     //
        //     Schema::table('orders', function($table)
        //     {
        //         $table->integer('payment_method_id')->unsigned();
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
        // if ( (Schema::hasTable('orders')) && (Schema::hasColumn('orders', 'payment_method_id')) ){

        //     Schema::table('orders', function($table)
        //     {
        //         $table->dropColumn('payment_method_id');
        //     });

        // }
        
    }
}

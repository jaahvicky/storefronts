<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcocashTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('ecocash_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->string('msiadn');
            $table->string('status');
            $table->integer('amount');
            $table->longText('response_data');
            $table->string('correlator');
            $table->timestamp('paid_on');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores');
            
            
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
        Schema::dropIfExists('ecocash_transaction');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

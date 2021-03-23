<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcocashconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('ecocash_config', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('ecocash_endpoint');
            $table->string('ecocash_endpoint_query');
            $table->string('ecocash_endpoint_query_user');
            $table->string('ecocash_channel');
            $table->string('ecocash_merchant_code');
            $table->string('ecocash_merchant_pin');
            $table->string('ecocash_merchant_number');
            $table->string('ecocash_username');
            $table->string('ecocash_password');
            $table->softDeletes();
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
        Schema::dropIfExists('ecocash_config');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

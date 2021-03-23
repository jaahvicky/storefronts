<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreEcocash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_ecocash', function (Blueprint $table) {
            $table->increments('id');
			
			$table->integer('store_id')->unsigned();
            $table->integer('account_type');
			
            $table->string('name');
			$table->string('number');
			
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
        Schema::dropIfExists('store_ecocash');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

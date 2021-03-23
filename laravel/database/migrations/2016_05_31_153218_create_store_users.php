<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_user', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id')->unsigned();
			$table->integer('user_id')->unsigned();
            		$table->softDeletes();
           		$table->timestamps();
                       // $table->timestamp('deleted_at');
			$table->foreign('store_id')->references('id')->on('stores');
			$table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('store_user');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

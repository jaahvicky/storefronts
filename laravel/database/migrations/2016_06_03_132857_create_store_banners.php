<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_banners', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id')->unsigned();
			
            $table->string('filename');
			$table->integer('order')->nullable();
			
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
        Schema::dropIfExists('store_banners');
    }
}

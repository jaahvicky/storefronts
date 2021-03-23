<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         Schema::create('logistics', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('url');
            $table->string('token');
            $table->string('method');
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
        Schema::dropIfExists('logistics');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnaiSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         Schema::create('ownai_system', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('url');
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
        Schema::dropIfExists('ownai_system');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

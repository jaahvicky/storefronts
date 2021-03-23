<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserLastActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create Num Views line
        Schema::table('users', function(Blueprint $table) {
            
            $table->timestamp('last_activity');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Dropping the coloumn
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}

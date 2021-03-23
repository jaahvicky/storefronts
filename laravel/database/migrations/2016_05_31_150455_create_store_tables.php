<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('countries', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('suburbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id')->unsigned();
            $table->string('name');

            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::create('store_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('slug');
            $table->integer('amount');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('countries')->insert([

            ['id' => 1, 'name' => 'Zimbabwe'],
        ]);

        // DB::table('store_types')->insert([

        //     ['id' => 1, 'type' => 'Vehicles', 'amount'=> 50],
        //     ['id' => 2, 'type' => 'Properties', 'amount'=> 50],
        //     ['id' => 3, 'type' => 'Other', 'amount'=> 10]
        // ]);

        Schema::create('store_delivery_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');  
            $table->timestamps();
        });

        Schema::create('store_status_types', function (Blueprint $table) {

            $table->increments('id');
            $table->string('label');
            $table->string('tag');
        });

        // DB::table('store_status_types')->insert([

        //     ['id' => 1, 'label' => 'Pending', 'tag' => 'pending-open'],
        //     ['id' => 2, 'label' => 'Pending', 'tag' => 'pending-reopen'],
        //     ['id' => 3, 'label' => 'Approved', 'tag' => 'approved'],
        //     ['id' => 4, 'label' => 'Rejected', 'tag' => 'rejected'],
        //     ['id' => 5, 'label' => 'Closed', 'tag' => 'closed'],
        // ]);

        Schema::create('stores', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('store_type_id')->unsigned();
          
            $table->integer('store_delivery_method_id')->unsigned();
            $table->integer('store_status_type_id')->unsigned();
            $table->timestamp('status_at');
            $table->timestamp('approved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('store_status_type_id')->references('id')->on('store_status_types');
            $table->foreign('store_delivery_method_id')->references('id')->on('store_delivery_methods');
            $table->foreign('store_type_id')->references('id')->on('store_types');
        });

        Schema::create('store_details', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->string('street_address_1');
            //$table->string('street_address_2');

            // $table->string('city');
            $table->integer('city_id')->unsigned();
            // $table->string('suburb');
            $table->integer('suburb_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->integer('migrated')->nullable();
            $table->string('collection_hours')->nullable();
            $table->decimal('location_lat', 10, 8);
            $table->decimal('location_lng', 11, 8);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            // not currently a required field as of writing comment
            $table->foreign('suburb_id')->references('id')->on('suburbs');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('store_id')->references('id')->on('stores');
        });

        Schema::create('store_contact_details', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('store_id')->unsigned();

            $table->string('firstname');
            $table->string('lastname');
            $table->string('street_address_1');
            $table->string('street_address_2');
            // $table->string('city');
            $table->integer('city_id')->unsigned();
            // $table->string('suburb');
            $table->integer('suburb_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->string('email')->nullable();
            $table->string('phone');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            // not currently a required field as of writing comment
            // $table->foreign('suburb_id')->references('id')->on('suburbs');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('store_id')->references('id')->on('stores');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('store_status_types');
        Schema::dropIfExists('store_details');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('suburbs');
        Schema::dropIfExists('store_types');
        Schema::dropIfExists('store_delivery_methods');
        Schema::dropIfExists('store_contact_details'); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/************************************************************/

/**      The code has been moved to create product_images table ****/

/***********************************************************/
class UpdateProductImagesAddFeatured extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('product_images', function ($table) {
        //     $table->boolean('featured')->after('effects');
        // }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('product_images', function ($table) {
        //     $table->dropColumn('featured');
        // }); 
    }
}

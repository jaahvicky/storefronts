<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/************************************************************/

/**      The code has been moved to create product table ****/

/***********************************************************/
class UpdateProductsChangeProductModerationTypeId extends Migration
{

    public function up()
    {

        // Schema::table('products', function ($table) {
        //     $table->dropForeign('products_product_moderation_type_id_foreign');
        //     $table->dropColumn('product_moderation_type_id');
        // });

        // Schema::table('products', function ($table) {
        //     $table->integer('product_moderation_type_id')->unsigned()->nullable();
        //     $table->foreign('product_moderation_type_id')->references('id')->on('product_moderation_types');
        // });
    }

    /**
     * Reverse the migrations. 
     *
     * @return void
     */
    public function down()
    {

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Schema::table('products', function ($table) {
        //     $table->dropForeign('products_product_moderation_type_id_foreign');
        //     $table->dropColumn('product_moderation_type_id');
        // });

        // Schema::table('products', function ($table) {
        //     $table->integer('product_moderation_type_id')->unsigned();
        //     $table->foreign('product_moderation_type_id')->references('id')->on('product_moderation_types');
        // });

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

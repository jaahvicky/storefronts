<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/************************************************************/

/**      The code has been moved to create product table ****/

/***********************************************************/
class UpdateProductsAddProductModerationTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::table('products', function ($table) {
        //     $table->integer('product_moderation_type_id')->unsigned();
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
        // Schema::table('products', function ($table) {
        //     $table->dropForeign('products_product_moderation_type_id_foreign');
        //     $table->dropColumn('product_moderation_type_id');
        // });
    }
}

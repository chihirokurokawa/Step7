<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('products', function (Blueprint $table) {
            // $table->integer('company_id')->unsigned();
            // $table->foreign('company_id')
            // ->references('id')->on('companies')
            // ->onDelete('no action');
            $table->biginteger('company_id')
                      ->unsigned()
                      ->foreign('company_id')
                      ->references('id')
                      ->on('companies')
                      ->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_company_id_foreign');
        });

    }
}

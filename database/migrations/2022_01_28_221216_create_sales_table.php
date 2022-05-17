<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sales')){
            Schema::create('sales', function (Blueprint $table) {
                $table->bigIncrements('id');
                //外部キー制約
                $table->integer('product_id')
                      ->unsigned()
                      ->foreign('product_id')
                      ->references('id')
                      ->on('products');
                $table->timestamps();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}

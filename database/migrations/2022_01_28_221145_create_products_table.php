<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')){
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                //外部キー制約
                // $table->biginteger('company_id')
                //       ->unsigned()
                //       ->foreign('company_id')
                //       ->references('id')
                //       ->on('companies');
                $table->string('product_name');
                $table->string('price');
                $table->string('stock');
                $table->text('comment');
                $table->text('img_path');
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
        Schema::dropIfExists('products');
    }
}

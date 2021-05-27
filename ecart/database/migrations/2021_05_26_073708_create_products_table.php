<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->varchar('name',128);
            $table->varchar('code',32);
            $table->double('price',32);
            $table->int('status',8);
            $table->int('available_stock',8);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
            ->references(['id'])->on('categories')
            ->onDelete('cascade');
            $table->timestamps();
            $table->  
        });
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

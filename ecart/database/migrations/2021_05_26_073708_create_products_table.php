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
            $table->string('name',128)->unique();
            $table->integer('code')->length(32)->unique();
            $table->double('price',32);
            $table->string('status',8);
            $table->integer('available_stock')->length(8);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
            ->references('id')->on('categories')
            ->onDelete('cascade');
            $table->timestamps();
            $table->string('image')->nullable();
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

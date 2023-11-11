<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 50)->unique();
            $table->string('description', 1000);
            $table->unsignedMediumInteger('price_including_tax');
            $table->string('purchase_site', 1500);
            $table->unsignedSmallInteger('brand_id');
            $table->unsignedTinyInteger('category_id');
            $table->unsignedMediumInteger('user_id');
            $table->timestamps();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->cascadeOnUpdate();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnUpdate();
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
};

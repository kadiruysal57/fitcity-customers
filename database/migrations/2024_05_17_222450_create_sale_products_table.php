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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->index('sale_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->index('product_id');
            $table->unsignedTinyInteger('quantity')->default(1)->nullable();
            $table->unsignedTinyInteger('tax')->default(0)->nullable();
            $table->unsignedFloat('liste_fiyati',15,2)->nullable();
            $table->unsignedFloat('indirim_tutari',15,2)->nullable();
            $table->unsignedFloat('birim_fiyat',15,2)->nullable();
            $table->unsignedFloat('toplam_fiyat',15,2)->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_products');
    }
};

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
        Schema::create('customer_families',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('medeni_hali',10)->nullable();
            $table->string('es_adi')->nullable();
            $table->date('evlilik_tarihi')->nullable();
            $table->date('es_dogum_tarihi')->nullable();
            $table->text('tebligat_adresi')->nullable();
            $table->string('ev_durumu',10)->nullable();
            $table->string('cocuk1_ad')->nullable();
            $table->date('cocuk1_dogum_tarihi')->nullable();
            $table->string('cocuk1_cinsiyet',10)->nullable();
            $table->string('cocuk2_ad')->nullable();
            $table->date('cocuk2_dogum_tarihi')->nullable();
            $table->string('cocuk2_cinsiyet',10)->nullable();
            $table->string('cocuk3_ad')->nullable();
            $table->date('cocuk3_dogum_tarihi')->nullable();
            $table->string('cocuk3_cinsiyet',10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_families');
    }
};

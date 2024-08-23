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
        Schema::create('customer_corporates',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('firma_adi')->nullable();
            $table->string('firma_adres')->nullable();
            $table->unsignedTinyInteger('firma_sehir_id')->nullable();
            $table->unsignedMediumInteger('firma_ilce_id')->nullable();
            $table->string('firma_semt')->nullable();
            $table->string('firma_web_adresi')->nullable();
            $table->string('meslek')->nullable();
            $table->string('is_telefonu',15)->nullable();
            $table->string('is_fax',15)->nullable();
            $table->string('is_dahili',15)->nullable();
            $table->string('diger_bilgiler')->nullable();
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
        Schema::dropIfExists('customer_corporates');
    }
};

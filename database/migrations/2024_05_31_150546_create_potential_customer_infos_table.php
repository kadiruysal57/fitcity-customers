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
        Schema::create('potential_customer_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('potential_customer_id');
            $table->foreign('potential_customer_id')->references('id')->on('potential_customers');
            $table->index('potential_customer_id');
            $table->string('meslek')->nullable();
            $table->string('firma_adi')->nullable();
            $table->string('firma_adres')->nullable();
            $table->unsignedTinyInteger('firma_sehir_id')->nullable();
            $table->unsignedMediumInteger('firma_ilce_id')->nullable();
            $table->string('cinsiyet',10)->nullable();
            $table->date('dogum_tarihi')->nullable();
            $table->string('medeni_hali',10)->nullable();
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
        Schema::dropIfExists('potential_customer_infos');
    }
};

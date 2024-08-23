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
        Schema::create('customer_infos',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('cinsiyet',10)->nullable();
            $table->string('kan_grubu',10)->nullable();
            $table->string('dogum_yeri')->nullable();
            $table->date('dogum_tarihi')->nullable();
            $table->string('egitim')->nullable();
            $table->string('arac_plaka_1',10)->nullable();
            $table->string('arac_plaka_2',10)->nullable();
            $table->string('kimlik_turu',15)->nullable();
            $table->string('favori_takim',30)->nullable();
            $table->string('ozel_durum')->nullable();
            $table->string('beden_olcusu',10)->nullable();
            $table->unsignedTinyInteger('hepatit_b_rapor_alindi')->default(0)->nullable();
            $table->text('hobiler')->nullable();
            $table->text('fobiler')->nullable();
            $table->text('diger_bilgiler')->nullable();
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
        Schema::dropIfExists('customer_infos');
    }
};

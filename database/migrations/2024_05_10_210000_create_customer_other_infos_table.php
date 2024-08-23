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
        Schema::create('customer_other_infos',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('fatura_ismi')->nullable();
            $table->text('diger_adres')->nullable();
            $table->unsignedTinyInteger('diger_sehir_id')->nullable();
            $table->unsignedMediumInteger('diger_ilce_id')->nullable();
            $table->string('el_izi_id')->nullable();
            $table->string('muhasebe_kodu')->nullable();
            $table->string('parmak_izi_id')->nullable();
            $table->string('muhasebe_kodu_2')->nullable();
            $table->unsignedBigInteger('referans_uye_id')->default(0)->nullable();
            $table->string('vergi_dairesi')->nullable();
            $table->string('vergi_no',11)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('customer_other_infos');
    }
};

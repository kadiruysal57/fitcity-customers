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
        Schema::create('customer_emergencies',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('ad_soyad')->nullable();
            $table->string('adres')->nullable();
            $table->string('yakinlik')->nullable();
            $table->string('cep',15)->nullable();
            $table->string('tel',15)->nullable();
            $table->string('hes_kodu',30)->nullable();
            $table->text('saglik_bilgiler')->nullable();
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
        Schema::dropIfExists('customer_emergencies');
    }
};

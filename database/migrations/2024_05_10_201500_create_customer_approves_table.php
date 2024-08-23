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
        Schema::create('customer_approves',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedTinyInteger('kvkk_onay')->default(0)->nullable();
            $table->unsignedTinyInteger('email_gonder')->default(0)->nullable();
            $table->unsignedTinyInteger('sms_gonder')->default(0)->nullable();
            $table->unsignedTinyInteger('arama_gonder')->default(0)->nullable();
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
        Schema::dropIfExists('customer_approves');
    }
};

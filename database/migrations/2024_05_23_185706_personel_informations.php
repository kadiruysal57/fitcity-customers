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
        Schema::create('personel_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personel_id');
            $table->string('tc_no',11)->nullable();
            $table->string('ev_no',11)->nullable();
            $table->string('cep_no',11)->nullable();
            $table->text('adres')->nullable();
            $table->integer('il')->nullable();
            $table->integer('ilce')->nullable();
            $table->string('semt')->nullable();
            $table->string('mahalle')->nullable();
            $table->timestamps();
            $table->foreign('personel_id')->references('id')->on('users_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

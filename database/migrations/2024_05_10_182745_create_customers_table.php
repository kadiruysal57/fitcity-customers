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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('ad')->nullable();
            $table->string('ikinci_ad')->nullable();
            $table->string('soyad')->nullable();
            $table->string('ozel_kod')->nullable();
            $table->string('kategori')->nullable();
            $table->string('telefon',15)->nullable()->index();
            $table->string('ev_telefonu',15)->nullable();
            $table->unsignedTinyInteger('sehir_id')->nullable();
            $table->unsignedMediumInteger('ilce_id')->nullable();
            $table->string('kaynak',30)->nullable();
            $table->string('tc_no',11)->unique()->nullable()->index();
            $table->string('email',50)->nullable();
            $table->string('email2',50)->nullable();
            $table->unsignedBigInteger('danisman_id')->default(0)->nullable();
            $table->unsignedMediumInteger('sube')->default(0)->nullable();
            $table->unsignedTinyInteger('durum')->default(1)->nullable();
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
        Schema::dropIfExists('customers');
    }
};

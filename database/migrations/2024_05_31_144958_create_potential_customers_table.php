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
        Schema::create('potential_customers', function (Blueprint $table) {
            $table->id();
            $table->string('ad')->nullable();
            $table->string('soyad')->nullable();
            $table->string('telefon',15)->nullable()->index();
            $table->string('ev_telefonu',15)->nullable();
            $table->string('email',50)->nullable();
            $table->text('adres')->nullable();
            $table->unsignedTinyInteger('sehir_id')->nullable();
            $table->unsignedMediumInteger('ilce_id')->nullable();
            $table->string('kaynak1',20)->nullable();
            $table->string('kaynak2',20)->nullable();
            $table->unsignedBigInteger('referans_uye')->nullable();
            $table->foreign('referans_uye')->references('id')->on('customers');
            $table->index('referans_uye');
            $table->unsignedBigInteger('ilgilenen_kisi')->nullable();
            $table->foreign('ilgilenen_kisi')->references('id')->on('users_admin');
            $table->index('ilgilenen_kisi');
            $table->unsignedBigInteger('uye_danismani')->nullable();
            $table->foreign('uye_danismani')->references('id')->on('users_admin');
            $table->index('uye_danismani');
            $table->unsignedBigInteger('uye_danismani2')->nullable();
            $table->foreign('uye_danismani2')->references('id')->on('users_admin');
            $table->index('uye_danismani2');
            $table->text('note')->nullable();
            $table->unsignedTinyInteger('email_gonder')->default(0)->nullable();
            $table->unsignedTinyInteger('sms_gonder')->default(0)->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
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
        Schema::dropIfExists('potential_customers');
        Schema::dropIfExists('potential_customer_records');
        Schema::dropIfExists('potential_customer_infos');
    }
};

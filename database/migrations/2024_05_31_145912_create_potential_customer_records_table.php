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
        Schema::create('potential_customer_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users_admin');
            $table->index('user_id');
            $table->unsignedBigInteger('potential_customer_id');
            $table->foreign('potential_customer_id')->references('id')->on('potential_customers');
            $table->index('potential_customer_id');
            $table->date('tarih')->default(now());
            $table->time('saat')->default(now());
            $table->unsignedBigInteger('uye_danismani')->nullable();
            $table->foreign('uye_danismani')->references('id')->on('users_admin');
            $table->index('uye_danismani');
            $table->string('takip_sekli',20)->nullable();
            $table->text('aciklama')->nullable();
            $table->string('olasilik',20)->nullable();
            $table->string('iletisim_sekli',20)->nullable();
            $table->string('takip_durumu',20)->nullable();
            $table->string('itiraz_sebebi',20)->nullable();
            $table->string('sonuc',20)->nullable();
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
        Schema::dropIfExists('potential_customer_records');
    }
};

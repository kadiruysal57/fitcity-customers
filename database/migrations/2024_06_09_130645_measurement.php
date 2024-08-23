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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->date('measurement_date')->nullable();
            $table->unsignedTinyInteger('measurement_type')->nullable();
            $table->unsignedInteger('measurement_size')->nullable();
            $table->unsignedDecimal('measurement_oil', 5, 2)->nullable();
            $table->unsignedDecimal('measurement_bmr', 5, 2)->nullable();
            $table->unsignedDecimal('measurement_visceral_fat', 5, 2)->nullable();
            $table->unsignedDecimal('weight', 5, 2)->nullable();
            $table->unsignedDecimal('bmi', 5, 2)->nullable();
            $table->unsignedDecimal('water', 5, 2)->nullable();
            $table->unsignedDecimal('kas', 5, 2)->nullable();
            $table->string('t_weight')->nullable();
            $table->string('fat_to_gain')->nullable();
            $table->string('t_fat_mass')->nullable();
            $table->string('t_to_loss')->nullable();
            $table->string('omuz')->nullable();
            $table->string('bel')->nullable();
            $table->string('sag_kol')->nullable();
            $table->string('sol_kol')->nullable();
            $table->string('sag_baldir')->nullable();
            $table->string('dinlenik_nabiz')->nullable();
            $table->string('gogus')->nullable();
            $table->string('karin')->nullable();
            $table->string('sol_baldir')->nullable();
            $table->string('tansiyon')->nullable();
            $table->string('gogus_alti')->nullable();
            $table->string('kalca')->nullable();
            $table->string('sag_bacak')->nullable();
            $table->string('basen')->nullable();
            $table->string('sol_bacak')->nullable();
            $table->string('bel_kalca_orani')->nullable();
            $table->string('uzun_atlama')->nullable();
            $table->string('yarim_mekik')->nullable();
            $table->string('denge_leylek_durusu_sag_bacak')->nullable();
            $table->string('one_esneme')->nullable();
            $table->string('ters_mekik')->nullable();
            $table->string('denge_leylek_durusu_sol_bacak')->nullable();
            $table->string('tutunma')->nullable();
            $table->string('sinav')->nullable();
            $table->string('yarim_barfiks')->nullable();
            $table->string('denge_ayak_ucunda_durus_sag_bacak')->nullable();
            $table->string('denge_ayak_ucunda_durus_sol_bacak')->nullable();
            $table->unsignedBigInteger('personel_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
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

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
        Schema::table('users_admin', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('branche_id')->nullable();
            $table->tinyInteger('gender')->default(3);
            $table->tinyInteger('first_aid_certificate')->default(2);
            $table->tinyInteger('emergency_team')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_admin', function (Blueprint $table) {
            //
        });
    }
};

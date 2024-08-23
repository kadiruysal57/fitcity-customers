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
        Schema::table('personel_informations', function (Blueprint $table) {
            $table->string('instagram_account')->nullable()->after('mahalle');
            $table->text('description')->nullable()->after('instagram_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personel_informations', function (Blueprint $table) {
            //
        });
    }
};

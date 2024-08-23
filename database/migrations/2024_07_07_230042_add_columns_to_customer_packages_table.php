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
        Schema::table('customer_packages', function (Blueprint $table) {
            $table->string('code',10)->nullable();
            $table->unsignedBigInteger('satis_temsilcisi')->nullable();
            $table->unsignedBigInteger('split')->nullable();
            $table->string('package_name')->nullable();
            $table->string('group')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable()->default(now());
            $table->unsignedTinyInteger('status')->default(2)->comment('1-tamam,0-iptal,2-bekliyor')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('renew')->default(0)->nullable();
            $table->unsignedTinyInteger('upgrade')->default(0)->nullable();
            $table->unsignedTinyInteger('transfer')->default(0)->nullable();
            $table->unsignedTinyInteger('single_invoice')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_packages', function (Blueprint $table) {
            //
        });
    }
};

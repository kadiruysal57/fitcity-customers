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
        Schema::create('package_transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_package_id');
            $table->unsignedBigInteger('old_customer_id');
            $table->unsignedBigInteger('new_customer_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_package_id')->references('id')->on('customer_packages');
            $table->foreign('old_customer_id')->references('id')->on('customers');
            $table->foreign('new_customer_id')->references('id')->on('customers');

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

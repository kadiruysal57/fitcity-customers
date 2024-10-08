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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price',15,2);
            $table->float('discount_price',15,2);
            $table->integer('discount_rate')->default(0);
            $table->integer('usage_time')->default(30)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('mobil_view')->default(2);
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
        //
    }
};

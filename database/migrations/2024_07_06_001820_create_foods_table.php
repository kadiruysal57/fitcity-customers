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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_category_id');
            $table->string('code');
            $table->string('name');
            $table->float('energy');
            $table->float('water');
            $table->float('protein');
            $table->float('fat');
            $table->float('carbohydrate');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('food_category_id')->references('id')->on('food_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
};

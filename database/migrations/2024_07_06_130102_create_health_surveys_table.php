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
        Schema::create('health_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->boolean('satisfaction')->nullable();
            $table->boolean('disease')->nullable();
            $table->string('disease_name')->nullable();
            $table->boolean('medication')->nullable();
            $table->string('medication_details')->nullable();
            $table->integer('exercise_days')->nullable();
            $table->integer('exercise_duration')->nullable();
            $table->string('past_diet')->nullable();
            $table->boolean('digestive_problems')->nullable();
            $table->integer('water_intake')->nullable();
            $table->boolean('allergies_milk')->nullable();
            $table->boolean('allergies_meat')->nullable();
            $table->boolean('allergies_vegetables')->nullable();
            $table->boolean('allergies_fruit')->nullable();
            $table->boolean('allergies_grains')->nullable();
            $table->boolean('dislike_milk')->nullable();
            $table->boolean('dislike_meat')->nullable();
            $table->boolean('dislike_vegetables')->nullable();
            $table->boolean('dislike_fruit')->nullable();
            $table->boolean('dislike_grains')->nullable();
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
        Schema::dropIfExists('health_surveys');
    }
};

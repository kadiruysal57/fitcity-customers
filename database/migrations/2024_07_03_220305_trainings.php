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
        Schema::create('trainings',function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->integer('second')->nullable();
            $table->integer('calorie')->nullable();
            $table->text('video')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('training_type');
            $table->unsignedBigInteger('training_level');
            $table->unsignedBigInteger('training_goal');
            $table->unsignedBigInteger('training_qeuipment');
            $table->unsignedBigInteger('training_focus_region');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('training_type')->references('id')->on('training_type');
            $table->foreign('training_level')->references('id')->on('training_level');
            $table->foreign('training_goal')->references('id')->on('training_goal');
            $table->foreign('training_qeuipment')->references('id')->on('training_qeuipment');
            $table->foreign('training_focus_region')->references('id')->on('training_focus_region');
            $table->foreign('category_id')->references('id')->on('mobil_categories');

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

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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personel_id');
            $table->string('title');
            $table->tinyInteger('lesson_type')->default(1);
            $table->unsignedBigInteger('category_id');
            $table->tinyInteger('stand_out')->default(2);
            $table->unsignedBigInteger('training_type');
            $table->unsignedBigInteger('training_level');
            $table->unsignedBigInteger('training_goal');
            $table->unsignedBigInteger('training_qeuipment');
            $table->unsignedBigInteger('training_focus_region');
            $table->date('lesson_date')->nullable();
            $table->time('lesson_start_time')->nullable();
            $table->time('lesson_finish_time')->nullable();
            $table->text('lesson_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('personel_id')->references('id')->on('users_admin');
            $table->foreign('category_id')->references('id')->on('mobil_categories');
            $table->foreign('training_type')->references('id')->on('training_type');
            $table->foreign('training_level')->references('id')->on('training_level');
            $table->foreign('training_goal')->references('id')->on('training_goal');
            $table->foreign('training_qeuipment')->references('id')->on('training_qeuipment');
            $table->foreign('training_focus_region')->references('id')->on('training_focus_region');
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

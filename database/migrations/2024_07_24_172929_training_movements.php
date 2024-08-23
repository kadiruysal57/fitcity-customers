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
        Schema::create('training_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_id');
            $table->integer('movement_order')->nullable();
            $table->text('movement_name')->nullable();
            $table->integer('repeat_count')->nullable();
            $table->integer('movement_time_second')->nullable();
            $table->integer('rest_period')->nullable();
            $table->text('movement_file')->nullable();
            $table->integer('status')->default(1);
            $table->foreign('training_id')->references('id')->on('trainings');
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

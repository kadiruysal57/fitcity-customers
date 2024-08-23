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
        Schema::create('personel_private_lesson', function (Blueprint $table) {
            $table->id();
            $table->string('lesson_name');
            $table->unsignedTinyInteger('category_id');
            $table->unsignedTinyInteger('personel_id');
            $table->integer('lesson_minute');
            $table->integer('unit');
            $table->float('price',15,2);
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('mobil_categories');
            $table->foreign('personel_id')->references('id')->on('users_admin');
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

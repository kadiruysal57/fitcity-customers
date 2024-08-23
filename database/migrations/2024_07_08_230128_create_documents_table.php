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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users_admin');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('process')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->date('request_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('validity_date')->nullable();
            $table->string('no')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('approve_user_id')->nullable();
            $table->unsignedTinyInteger('status')->default(2)->nullable();
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
        Schema::dropIfExists('documents');
    }
};

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
        Schema::create('roles_list', function (Blueprint $table) {
            $table->id();
            $table->string('roles_name');
            $table->integer('status');
            $table->integer('add_user')->nullable();
            $table->timestamps();
        });

        DB::table('roles_list')->insert(
            array(
                'roles_name'=> "dashboard",
                'status' => 1,
                'add_user' => 1,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_list');
    }
};

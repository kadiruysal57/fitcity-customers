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
        Schema::create('users_admin', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->string('email')->unique();
            $table->unsignedBigInteger('permission_role');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('add_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('permission_role')->references('id')->on('permission_table');
        });

        DB::table('users_admin')->insert(
            array(
                'name' => 'Kadir Uysal',
                'email' => "kadir@gmail.com",
                'permission_role' => 1,
                'status' => 1,
                'password' => \Illuminate\Support\Facades\Hash::make("Kadir.uysal1301"),
                'add_user' => 1,
                'update_user' => 1,
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
        Schema::dropIfExists('users');
    }
};

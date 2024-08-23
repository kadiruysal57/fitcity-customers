<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_venues', function (Blueprint $table) {
            $table->id();
            $table->text('venues_name')->nullable();
            $table->integer('status')->default(1);
            $table->integer('venues_order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('training_venues')->insert([
            ['venues_name' => 'Kulüpte', 'status' => 1,'venues_order'=>1],
            ['venues_name' => 'Evde', 'status' => 1,'venues_order'=>2],
            ['venues_name' => 'Dışarıda', 'status' => 1,'venues_order'=>3],
        ]);
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

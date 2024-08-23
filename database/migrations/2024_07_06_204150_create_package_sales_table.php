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
        Schema::create('package_sales', function (Blueprint $table) {
            $table->id();
            $table->string('code',10);
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('satis_temsilcisi')->nullable();
            $table->unsignedBigInteger('split')->nullable();
            $table->string('package_name');
            $table->string('group');
            $table->string('type');
            $table->float('discount_price',15,2);
            $table->date('date');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('status')->default(2)->comment('1-tamam,0-iptal,2-bekliyor');
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('renew')->default(0);
            $table->unsignedTinyInteger('upgrade')->default(0);
            $table->unsignedTinyInteger('transfer')->default(0);
            $table->unsignedTinyInteger('single_invoice')->default(0);
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
        Schema::dropIfExists('package_sales');
    }
};

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
        Schema::create('schedules_has_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_price_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('quantity');
            $table->string('unity', 50);
            $table->float('price');
            $table->integer('discount');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('product_price_id')->references('id')->on('product_prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules_has_products');
    }
};

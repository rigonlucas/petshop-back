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
        Schema::create('pet_vaccines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vaccine_id');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('schedule_id')->nullable()->default(null);
            $table->boolean('applied')->default(false);
            $table->date('applied_at')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('vaccine_id')
                ->references('id')
                ->on('vaccines')
                ->onDelete('cascade');
            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onDelete('cascade');
            $table->foreign('schedule_id')
                ->references('id')
                ->on('schedules')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_vaccines');
    }
};

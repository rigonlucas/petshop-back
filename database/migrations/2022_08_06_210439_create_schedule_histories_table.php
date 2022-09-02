<?php

use App\Models\Schedules\Schedule;
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
        Schema::create('schedule_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id')->default(null);
            $table->text('register');
            $table->tinyInteger('type');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_registers');
    }
};

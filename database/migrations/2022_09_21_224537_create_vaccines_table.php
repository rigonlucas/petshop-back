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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 500);
            $table->tinyInteger('type');
            $table->smallInteger('number_first_shoot')->default(1);
            $table->smallInteger('number_first_shoot_days')->default(null)->nullable();
            $table->smallInteger('days_to_booster_dose')->default(365);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccines');
    }
};

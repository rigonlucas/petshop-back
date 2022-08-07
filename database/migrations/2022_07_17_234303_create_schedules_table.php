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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedSmallInteger('type');
            $table->unsignedSmallInteger('status');
            $table->timestamp('start_at');
            $table->unsignedSmallInteger('duration');
            $table->text('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};

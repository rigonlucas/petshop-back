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
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->unsignedBigInteger('schedule_recurrence_id')->nullable()->default(null);
            $table->tinyInteger('type');
            $table->tinyInteger('status');
            $table->timestamp('start_at');
            $table->unsignedSmallInteger('duration');
            $table->timestamp('finish_at')->virtualAs('DATE_ADD(start_at, INTERVAL duration MINUTE)');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onDelete('cascade');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
            $table->foreign('schedule_recurrence_id')
                ->references('id')
                ->on('schedule_recurrences')
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
        Schema::dropIfExists('schedules');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->timestamp('finish_at')->after('duration')->virtualAs('DATE_ADD(start_at, INTERVAL duration MINUTE)');
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('finish_at');
        });
    }
};

<?php

namespace Database\Seeders;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Models\Users\Account;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::factory()->count(50)->create([
            'status' => SchedulesStatusEnum::SCHEDULED->value,
            'account_id' => 1
        ]);
    }
}

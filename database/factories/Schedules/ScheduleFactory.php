<?php

namespace Database\Factories\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleFactory extends Factory
{
    public function definition()
    {
        $client = Client::factory()->has(Pet::factory()->count(1))->create();
        return [
            'account_id' => Account::factory(),
            'client_id' => $client->id,
            'pet_id' => $client->pets->first()->id,
            'user_id' => null,
            'type' => SchedulesTypesEnum::random(),
            'status' => SchedulesStatusEnum::random(),
            'start_at' => Carbon::today()->addDays(random_int(0, 20)),
            'duration' => random_int(15, 60)
        ];
    }
}

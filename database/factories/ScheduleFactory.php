<?php

namespace Database\Factories;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Account;
use App\Models\Breed;
use App\Models\Client;
use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        $client = Client::factory()->create();
        return [
            'pet_id' => Pet::factory([
                'client_id' => $client->id
            ]),
            'client_id' => $client,
            'account_id' => Account::factory(),
            'user_id' => User::factory(),
            'type' => SchedulesTypesEnum::random(),
            'status' => SchedulesStatusEnum::random(),
            'start_at' => Carbon::now()->addDay(),
            'duration' => random_int(10, 60),
            'description' => $this->faker->text()
        ];
    }
}

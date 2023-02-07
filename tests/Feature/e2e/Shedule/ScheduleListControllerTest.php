<?php

namespace Tests\Feature\e2e\Shedule;

use App\Enums\SchedulesStatusEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Schedules\Schedule;
use App\Models\User;
use Tests\TestCase;

class ScheduleListControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_schedule_list()
    {
        $user = User::factory()->create();
        Schedule::factory()->create([
            'account_id' => $user->account_id,
            'client_id' => Client::factory()->create([
                'account_id' => $user->account_id
            ]),
            'pet_id' => Pet::factory()->create([
                'account_id' => $user->account_id
            ]),
            'status' => SchedulesStatusEnum::SCHEDULED
        ]);
        $response = $this
            ->actingAs($user)
            ->get(route('schedules.index', ['include' => 'client,pet,user']));
        $response->assertStatus(200);
        //$response->dd();
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "user_id",
                    "client_id",
                    "account_id",
                    "pet_id",
                    "type",
                    "status",
                    "start_at",
                    "finish_at",
                    "duration",
                    "description",
                    "created_at",
                    "updated_at",
                    "pet" => [
                        "id",
                        "name",
                        "client_id",
                    ],
                    "client" => [
                        "id",
                        "name",
                        "email",
                        "phone",
                        "created_at",
                        "updated_at",
                    ],
                    "user",
                ]
            ],
            'meta' => [
                'per_page',
                'current_page',
                'total',
                'last_page'
            ]
        ]);
    }
}

<?php

namespace Tests\Feature\e2e\Shedule;

use App\Enums\SchedulesStatusEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Schedules\Schedule;
use App\Models\User;
use Tests\TestCase;

class ScheduleShowControllerTest extends TestCase
{
    public function test_show()
    {
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create([
            'account_id' => $user->account_id,
            'client_id' => Client::factory()->create([
                'account_id' => $user->account_id
            ]),
            'user_id' => $user->id,
            'pet_id' => Pet::factory()->create([
                'account_id' => $user->account_id
            ]),
            'status' => SchedulesStatusEnum::SCHEDULED
        ]);
        $response = $this
            ->actingAs($user)
            ->get(route('schedules.show', ['id' => $schedule->id, 'include' => 'client,pet,user']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'user_id',
                'client_id',
                'account_id',
                'pet_id',
                'type',
                'status',
                'start_at',
                'finish_at',
                'duration',
                'description',
                'created_at',
                'updated_at',
                'pet' => [
                    'id',
                    'name',
                ],
                'client' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                ],
                'user' => [
                    'id',
                    'email',
                ],
            ]
        ]);
    }
}

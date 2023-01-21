<?php

namespace Tests\Feature\Core\Modules\App\Vaccine\List;

use App\Models\Products\Vaccine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group test_controller_vaccines
 */
class ListOfVaccinesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_vaccines_without_filter()
    {
        $user = User::factory()->create();
        Vaccine::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('vaccine.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'nome',
                    'type',
                    'number_first_shoot',
                    'number_first_shoot_days',
                    'days_to_booster_dose',
                    'created_at',
                    'updated_at',
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

    /**
     * @group test_controller_vaccines_filter_name
     */
    public function test_list_of_vaccines_with_filter_name()
    {
        $user = User::factory()->create();
        Vaccine::factory()->count(2)->create();
        $filterVaccine = Vaccine::factory()->create([
            'name' => 'Vaccine 1 test feature api'
        ]);
        $response = $this
            ->actingAs($user)
            ->get(
                route('vaccine.index', ['name' => $filterVaccine->name])
            );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'nome',
                    'type',
                    'number_first_shoot',
                    'number_first_shoot_days',
                    'days_to_booster_dose',
                    'created_at',
                    'updated_at',
                ]
            ],
            'meta' => [
                'per_page',
                'current_page',
                'total',
                'last_page'
            ]
        ]);

        $data = json_decode($response->getContent());
        $this->assertCount(1, $data->data);
        $this->assertEquals(Vaccine::query()->count(), 3);
    }
}

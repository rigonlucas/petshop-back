<?php

namespace Database\Seeders;

use App\Models\Clients\Client;
use App\Models\Types\Breed;
use Illuminate\Database\Seeder;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Breed::factory()->create();
    }
}

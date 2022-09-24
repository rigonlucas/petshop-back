<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AccountSeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
            PermissionSeeder::class,
            MenuPermissionSeeder::class,
            UserPermissionSeeder::class,
            VaccineSeeder::class,
            PetVaccineSeeder::class
        ]);
    }
}

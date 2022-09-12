<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->get();
        $permissions = Permission::query()->pluck('name');
        /** @var User $user */
        foreach ($users as $user) {
            $user->givePermissionTo($permissions);
            $user->assignRole('User Admin');
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'user_management_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'schedule_create',
            'schedule_edit',
            'schedule_show',
            'schedule_delete',
            'schedule_access',
            'product_create',
            'product_edit',
            'product_show',
            'product_delete',
            'product_access',
            'client_create',
            'client_edit',
            'client_show',
            'client_delete',
            'client_access',
        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => 'User Admin']);

        $role = Role::create(['name' => 'User']);

        $userPermissions = [
            'user_management_access',
            'schedule_create',
            'schedule_edit',
            'schedule_show',
            'schedule_delete',
            'schedule_access',
            'product_create',
            'product_edit',
            'product_show',
            'product_delete',
            'product_access',
            'client_create',
            'client_edit',
            'client_show',
            'client_delete',
            'client_access',
        ];

        foreach ($userPermissions as $permission)   {
            $role->givePermissionTo($permission);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $userRole = Role::create(['name' => 'user']);
        $driverRole = Role::create(['name' => 'driver']);
        $assistantRole = Role::create(['name' => 'assistant']);

        // Create permissions for users
        Permission::create(['name' => 'create service posts']);
        Permission::create(['name' => 'view drivers']);
        Permission::create(['name' => 'contact drivers']);

        // Create permissions for drivers
        Permission::create(['name' => 'view service posts']);
        Permission::create(['name' => 'create helper posts']);
        Permission::create(['name' => 'view assistants']);
        Permission::create(['name' => 'contact users']);

        // Create permissions for assistants
        Permission::create(['name' => 'view helper posts']);
        Permission::create(['name' => 'respond to helper posts']);

        // Assign permissions to roles
        $userRole->givePermissionTo(['create service posts', 'view drivers', 'contact drivers']);
        $driverRole->givePermissionTo(['view service posts', 'create helper posts', 'view assistants', 'contact users']);
        $assistantRole->givePermissionTo(['view helper posts', 'respond to helper posts', 'contact drivers']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'view-task']);
        Permission::create(['name' => 'create-task']);
        Permission::create(['name' => 'edit-task']);
        Permission::create(['name' => 'delete-task']);

        Permission::create(['name' => 'view-category']);
        Permission::create(['name' => 'create-category']);
        Permission::create(['name' => 'edit-category']);
        Permission::create(['name' => 'delete-category']);

        $adminRole = Role::create(['name' => 'Admin']);
        $employeeRole = Role::create(['name' => 'Employee']);

        $adminRole->givePermissionTo([
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'view-task',
            'create-task',
            'edit-task',
            'delete-task',
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',
        ]);

        $employeeRole->givePermissionTo([
            'view-task',
            'create-task',
            'edit-task',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view-notes']);
        Permission::create(['name' => 'create-note']);
        Permission::create(['name' => 'edit-own-note']);
        Permission::create(['name' => 'edit-any-note']);
        Permission::create(['name' => 'delete-own-note']);
        Permission::create(['name' => 'delete-any-note']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('view-notes');
        $role->givePermissionTo('create-note');
        $role->givePermissionTo('edit-own-note');
        $role->givePermissionTo('delete-own-note');

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('view-notes');
        $role->givePermissionTo('create-note');
        $role->givePermissionTo('edit-any-note');
        $role->givePermissionTo('delete-any-note');
    }
}

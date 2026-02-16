<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view-note',
            'create-note',
            'edit-note',
            'delete-note',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // admin can do everything
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // editor can only add, edit, view
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'create-note',
            'edit-note',
            'view-note'
        ]);

        // Programmatic Role Assignment (Spatie Method)
        User::where('email', 'Anouar@example.com')->first()?->assignRole($adminRole);
        User::where('email', 'Mehdi@example.com')->first()?->assignRole($editorRole);
        User::where('email', 'Nabil@example.com')->first()?->assignRole($editorRole);
    }
}

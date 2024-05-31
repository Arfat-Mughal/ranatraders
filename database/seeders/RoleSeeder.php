<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesWithPermissions = [
            'Super Admin' => [
                'create-role',
                'edit-role',
                'delete-role',
                'create-user',
                'edit-user',
                'delete-user',
                'create-product',
                'edit-product',
                'delete-product'
            ],
            'Admin' => [
                'create-user',
                'edit-user',
                'delete-user',
                'create-product',
                'edit-product',
                'delete-product'
            ],
            'Manager' => [
                'create-product',
                'edit-product',
                'delete-product'
            ],
        ];

        foreach ($rolesWithPermissions as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}

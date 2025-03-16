<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        # Daftar permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'manage roles',
            'manage permissions', 
        ];

        # Buat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        # Definisikan roles beserta permissions-nya
        $roles = [
            'admin' => [
                'view users',
                'create users',
                'edit users',
                'delete users',
                'view posts',
                'create posts',
                'edit posts',
                'delete posts',
                'manage roles', 
                'manage permissions', 
            ],
            'editor' => [
                'view posts',
                'create posts',
                'edit posts',
                'delete posts',
            ],
            'contributor' => [
                'view posts',
                'create posts',
                'edit posts',
            ],
            'user' => [ 
                'view posts',
            ],
        ];

        # Buat dan assign permissions ke roles
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        # Definisikan users utama
        $users = [
            'admin' => [
                'email' => 'admin@kuliit.com',
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            'editor' => [
                'email' => 'editor@kuliit.com',
                'name' => 'Editor',
                'slug' => 'editor',
            ],
            'contributor' => [
                'email' => 'kontributor@kuliit.com',
                'name' => 'Kontributor',
                'slug' => 'kontributor',
            ],
        ];

        # Buat users utama dan assign roles
        foreach ($users as $role => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'slug' => $userData['slug'],
                    'password' => Hash::make('password123'),
                ]
            );
            $user->assignRole($role);
        }

        # Buat user tambahan dengan role 'user'
        for ($i = 1; $i <= 2; $i++) {
            $randomUser = User::firstOrCreate(
                ['email' => "user{$i}@kuliit.com"],
                [
                    'name' => "User {$i}",
                    'slug' => "user-{$i}",
                    'password' => Hash::make('password123'),
                ]
            );
            $randomUser->assignRole('user');
        }
    }
}
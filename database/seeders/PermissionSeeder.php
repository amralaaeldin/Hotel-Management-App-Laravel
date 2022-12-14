<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view clients',
            'add clients',
            'edit clients',
            'delete clients',

            'view receptionists',
            'add receptionists',
            'edit receptionists',
            'delete receptionists',
            'ban receptionists',

            'view admins',
            'add admins',
            'edit admins',
            'delete admins',

            'view managers',
            'add managers',
            'edit managers',
            'delete managers',

            'view rooms',
            'add rooms',
            'edit rooms',
            'delete rooms',

            'view floors',
            'add floors',
            'edit floors',
            'delete floors',

            'view reservations',

            'view permissions',
            'add permissions',
            'edit permissions',
            'delete permissions',

            'view roles',
            'add roles',
            'edit roles',
            'delete roles',
        ];

        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $receptionist = Role::create(['name' => 'receptionist']);
        $manager = Role::create(['name' => 'manager']);

        $admin->syncPermissions($permissions);
        $receptionist->syncPermissions([
            'view clients',
            'add clients',

            'view reservations',
        ]);
        $manager->syncPermissions([
            'view clients',
            'add clients',
            'edit clients',
            'delete clients',

            'view rooms',
            'add rooms',
            'edit rooms',
            'delete rooms',

            'view floors',
            'add floors',
            'edit floors',
            'delete floors',

            'view receptionists',
            'add receptionists',
            'edit receptionists',
            'delete receptionists',
            'ban receptionists',

            'view reservations',
        ]);

        $admin1 = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $admin1->assignRole($admin);

        $manager1 = User::create([
            'email' => 'manager@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $manager1->assignRole($manager);

        $receptionist1 = User::create([
            'email' => 'receptionist@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $receptionist1->assignRole($receptionist);
    }
}

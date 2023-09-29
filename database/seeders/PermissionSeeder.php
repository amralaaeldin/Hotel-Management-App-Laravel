<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            'admin',
            'receptionist',
            'manager',
        ];
        foreach ($roles as $role) {
            $$role = Role::create(['name' => $role]);
        }

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
            'name' => 'Admin1',
            'national_id' => '12345678901233',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $admin1->assignRole($admin);

        $manager1 = User::create([
            'name' => 'Manager1',
            'national_id' => '12345678901234',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('12345678'),
            'created_by' => $admin1->id
        ]);

        $manager1->assignRole($manager);

        $receptionist1 = User::create([
            'name' => 'Receptionist1',
            'national_id' => '12345678901235',
            'email' => 'receptionist@gmail.com',
            'password' => bcrypt('12345678'),
            'created_by' => $admin1->id
        ]);

        $receptionist1->assignRole($receptionist);
    }
}

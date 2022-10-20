<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Str;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'=>Str::random(16)
        ];
        # create User
        $superadmin = User::create(array_merge([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',  
        ],$detail));
        $adminfinance = User::create(array_merge([
            'name' => 'Admin Finance',
            'email' => 'adminfinance@gmail.com'
        ],$detail));

        #create Role
        $role_superadmin = Role::create(['name' => 'superadmin']);
        $role_adminfinance = Role::create(['name' => 'adminfinance']);

        #assign role
        $superadmin->assignRole('superadmin');
        $adminfinance->assignRole('adminfinance');

        #create permission
        #menu setting
        Permission::create(['name'=>'menu setting']);
        Permission::create(['name'=>'create user']);
        Permission::create(['name'=>'read user']);
        Permission::create(['name'=>'update user']);
        Permission::create(['name'=>'delete user']);
        Permission::create(['name'=>'create role']);
        Permission::create(['name'=>'read role']);
        Permission::create(['name'=>'update role']);
        Permission::create(['name'=>'delete role']);
        Permission::create(['name'=>'create permission']);
        Permission::create(['name'=>'read permission']);
        Permission::create(['name'=>'update permission']);
        Permission::create(['name'=>'delete permission']);

        #Give Permission
        $role_superadmin->givePermissionTo('menu setting');
        $role_superadmin->givePermissionTo('create user');
        $role_superadmin->givePermissionTo('read user');
        $role_superadmin->givePermissionTo('update user');
        $role_superadmin->givePermissionTo('delete user');
        $role_superadmin->givePermissionTo('create role');
        $role_superadmin->givePermissionTo('read role');
        $role_superadmin->givePermissionTo('update role');
        $role_superadmin->givePermissionTo('delete role');
        $role_superadmin->givePermissionTo('create permission');
        $role_superadmin->givePermissionTo('read permission');
        $role_superadmin->givePermissionTo('update permission');
        $role_superadmin->givePermissionTo('delete permission');

    }
}

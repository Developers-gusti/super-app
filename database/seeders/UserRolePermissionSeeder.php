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
     *_run the database seeds.
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
        Permission::create(['name'=>'menu_setting']);
        Permission::create(['name'=>'create_user']);
        Permission::create(['name'=>'read_user']);
        Permission::create(['name'=>'update_user']);
        Permission::create(['name'=>'delete_user']);
        Permission::create(['name'=>'create_role']);
        Permission::create(['name'=>'read_role']);
        Permission::create(['name'=>'update_role']);
        Permission::create(['name'=>'delete_role']);
        Permission::create(['name'=>'create_permission']);
        Permission::create(['name'=>'read_permission']);
        Permission::create(['name'=>'update_permission']);
        Permission::create(['name'=>'delete_permission']);

        #Give Permission
        $role_superadmin->givePermissionTo('menu_setting');
        $role_superadmin->givePermissionTo('create_user');
        $role_superadmin->givePermissionTo('read_user');
        $role_superadmin->givePermissionTo('update_user');
        $role_superadmin->givePermissionTo('delete_user');
        $role_superadmin->givePermissionTo('create_role');
        $role_superadmin->givePermissionTo('read_role');
        $role_superadmin->givePermissionTo('update_role');
        $role_superadmin->givePermissionTo('delete_role');
        $role_superadmin->givePermissionTo('create_permission');
        $role_superadmin->givePermissionTo('read_permission');
        $role_superadmin->givePermissionTo('update_permission');
        $role_superadmin->givePermissionTo('delete_permission');

    }
}

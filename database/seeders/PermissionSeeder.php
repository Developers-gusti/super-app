<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        Permission::create(['name'=>'read setting']);
        Permission::create(['name'=>'create user']);
        Permission::create(['name'=>'read user']);
        Permission::create(['name'=>'update user']);
        Permission::create(['name'=>'delete user']);
        
        $user->givePermissionTo('read user');
        $user->givePermissionTo('create user');
        $user->givePermissionTo('read user');
        $user->givePermissionTo('update user');
        $user->givePermissionTo('delete user');
    }
}

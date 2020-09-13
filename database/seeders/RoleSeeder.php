<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name' => 'root',
                'guard_name' => 'admin'
            ],[
                'name' => 'Super Admin',
                'guard_name' => 'admin'
            ],[
                'name' => 'Admin',
                'guard_name' => 'admin'
            ],[
                'name' => 'Manager',
                'guard_name' => 'admin'
            ],[
                'name' => 'Editor',
                'guard_name' => 'admin'
            ],[
                'name' => 'root',
                'guard_name' => 'api'
            ],[
                'name' => 'Super Admin',
                'guard_name' => 'api'
            ],[
                'name' => 'Admin',
                'guard_name' => 'api'
            ],[
                'name' => 'Manager',
                'guard_name' => 'api'
            ],[
                'name' => 'Editor',
                'guard_name' => 'api'
            ]
        ]);
    }
}

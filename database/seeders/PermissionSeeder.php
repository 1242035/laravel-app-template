<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'read',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'write',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'update',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'delete',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'read',
                'guard_name' => 'api'
            ],
            [
                'name' => 'write',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete',
                'guard_name' => 'api'
            ]
        ]);
    }
}

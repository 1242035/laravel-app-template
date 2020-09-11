<?php

namespace App\Repositories\Admin;

use App\Models\Role;

class RoleRepository extends \App\Repositories\Base\RoleRepository
{
    public function store(array $data)
    {
        return Role::create($data);
    }
}

<?php

namespace App\Repositories\Admin;

use App\Models\Permission;

class PermissionRepository extends \App\Repositories\Base\PermissionRepository
{
    public function store(array $data)
    {
        return Permission::create($data);
    }
}

<?php

namespace App\Repositories\Base;

use App\Models\Permission;

abstract class PermissionRepository extends BaseRepository
{
    public function get($id)
    {
        return Permission::findOrFail($id);
    }

    public function all()
    {
        return Permission::all();
    }

    public function getAll($params = [], $page = 1, $limit = 25)
    {
        return Permission::paginate($limit);
    }

    public function update(array $data, $id)
    {
        return null;
    }
}

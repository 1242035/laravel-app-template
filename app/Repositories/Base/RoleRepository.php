<?php

namespace App\Repositories\Base;


use App\Models\Role;

abstract class RoleRepository extends BaseRepository
{
    public function get($id)
    {
        return Role::findOrFail($id);
    }

    public function all()
    {
        return Role::all();
    }

    public function getAll($params = [], $page = 1, $limit = 25)
    {
        return Role::paginate( $limit );
    }
}

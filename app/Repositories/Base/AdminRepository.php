<?php

namespace App\Repositories\Base;


use App\Models\Admin;

abstract class AdminRepository extends BaseRepository
{
    public function get($id)
    {
        return Admin::findOrFail($id);
    }
}

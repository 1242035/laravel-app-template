<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

class AdminRepository extends \App\Repositories\Base\AdminRepository
{
    public function store(array $data)
    {
        $data['password'] = \Hash::make($data['password']);

        return Admin::create($data);
    }

    /**
     * [update Update specify Customer]
     * @param array $data [attributes data]
     * @param  [int] $id   [id of Customer]
     * @return [array]       [response message]
     */
    public function update(array $data, $id)
    {

        if ($data['password']) {
            unset($data['password']);
        }
        if ($data['email']) {
            unset($data['email']);
        }

        $user = Admin::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function getAll($params = [], $page = 1, $limit = 25)
    {
        return Admin::paginate( $limit );
    }   
}

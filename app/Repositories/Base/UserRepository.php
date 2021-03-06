<?php

namespace App\Repositories\Base;

use App\Models\User;
use Hash;

class UserRepository extends BaseRepository
{
    public function get($id)
    {
        return User::findOrFail($id);
    }
    
    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
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

        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function getAll($params = [], $page = 1, $limit = 25)
    {
        return User::simplePaginate($limit);
    }
}

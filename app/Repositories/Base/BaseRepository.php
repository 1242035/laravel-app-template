<?php

namespace App\Repositories\Base;

abstract class BaseRepository
{
    abstract public function store(array $data);
    
    abstract public function update(array $data, $id);

    abstract public function getAll($params, $page = 1, $limit = 25);

    abstract public function get($id);
}

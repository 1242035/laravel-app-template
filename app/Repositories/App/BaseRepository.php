<?php

namespace App\Repositories\App;

abstract class BaseRepository
{
    
    public abstract function store(array $data);
    
    public abstract function update(array $data, $id);

    public abstract function getAll( $params , $page = 1, $limit = 25);

    public abstract function get($id);
    
}

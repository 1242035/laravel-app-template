<?php

namespace App\Repositories;

abstract class BaseRepository
{
    
    public abstract static function store(array $data);
    
    public abstract static function update(array $data, $id);

    public abstract static function getAll( $params , $limit);

    public abstract static function get($id);
    
}

<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use Exception;

abstract class Controller extends \App\Http\Controllers\Api\Controller
{
    protected $repository;

    protected function _success($data = [], $code = 200)
    {
        return $this->_response($data, $code);
    }

    protected function _error($data = [], $code = 500)
    {
        return $this->_response($data, $code);
    }

    protected function _response( $data = [], $code = 500 )
    {
        return response()->json( $data, $code );
    }
}

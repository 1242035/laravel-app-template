<?php

namespace App\Http\Controllers;

abstract class ApiController extends \App\Http\Controllers\Controller
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
        return api_response( $data, $code );
    }
}

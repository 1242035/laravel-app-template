<?php

namespace App\Http\Controllers;

abstract class ApiController extends \App\Http\Controllers\Controller
{
    protected $repository;

    protected function success($data = [], $code = 200)
    {
        return $this->response($data, $code);
    }

    protected function error($data = [], $code = 500)
    {
        return $this->response($data, $code);
    }

    protected function notFound($data = [], $code = 404)
    {
        return $this->response($data, $code);
    }

    protected function response($data = [], $code = 500)
    {
        return app_response($data, $code);
    }
}

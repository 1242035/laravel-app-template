<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        return view('web.home.index');
    }
}

<?php

namespace App\Models;

class Example extends Base
{
    protected $table = 'examples';

    protected $fillable = [
        'name',
        'code',
        'status'
    ];
}

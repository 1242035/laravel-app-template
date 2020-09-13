<?php

namespace App\Models;
use App\Models\Traits\BaseEventTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use BaseEventTrait;
}

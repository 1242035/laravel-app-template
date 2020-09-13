<?php

namespace App\Models;
use App\Models\Traits\BaseEventTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
    use BaseEventTrait;
}

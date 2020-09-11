<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseEventTrait;

abstract class Base extends Model
{
    use BaseEventTrait;
}

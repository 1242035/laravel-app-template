<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\BaseEventTrait;

abstract class Base extends Model
{
    use BaseEventTrait, HasFactory, Notifiable;
}

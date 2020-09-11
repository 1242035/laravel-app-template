<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseEventTrait;

abstract class BaseAuth extends Authenticatable implements UserInterface
{
    use Notifiable, HasApiTokens, HasRoles, SoftDeletes, BaseEventTrait;

    
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function findForPassport($username)
    {
        return $this->where('username', $username)->orWhere('email', $username)->orWhere('phone', $username)->first();
    }
}

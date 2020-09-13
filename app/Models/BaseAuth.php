<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Traits\BaseEventTrait;

abstract class BaseAuth extends Authenticatable implements UserInterface
{
    use Notifiable, HasFactory, HasApiTokens, HasRoles;

    use BaseEventTrait { restore as private restoreA; restoring as private restoringA; restored as private restoredA; }
    use SoftDeletes { restore as private restoreB; restoring as private restoringB; restored as private restoredB; }

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function findForPassport($username)
    {
        return $this->where('user_name', $username)->orWhere('email', $username)->orWhere('phone', $username)->first();
    }

    /**
     * fix collision on restore methods in SoftDelete trait and Entrust trait
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function restoring()
    {
        $this->restoringA();
        $this->restoringB();
    }

    public function restored()
    {
        $this->restoredA();
        $this->restoredB();
    }
}

<?php

namespace App\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\UserInterface;

abstract class Base
{
    use HandlesAuthorization;

    public function before(UserInterface $user, $ability)
    {
        return $user && $user->isSuperAdmin() ? true : null; 
    }
}

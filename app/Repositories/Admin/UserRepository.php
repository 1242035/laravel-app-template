<?php

namespace App\Repositories\Admin;

class UserRepository extends \App\Repositories\Base\UserRepository
{
    public function resetPassword($email, $password)
    {
        $item = User::find(['email' => $email])->first();
        if (isset($item->id)) {
            $item->update(['password' => \Hash::make($password)]);
            return $item;
        }

        return null;
    }
}

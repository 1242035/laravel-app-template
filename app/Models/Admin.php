<?php

namespace App\Models;

class Admin extends BaseAuth
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'status',
        'first_name',
        'last_name',
        'last_logged_in_at',
    ];

    protected $casts = [
        'last_logged_in_at' => 'datetime',
    ];

    public function isAdminAccount()
    {
        return true;
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('root');
    }
}

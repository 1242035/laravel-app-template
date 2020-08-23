<?php

namespace App\Models;

interface UserInterface
{
    public function isSuperAdmin();

    public function isAdminAccount();
}
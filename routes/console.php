<?php

use App\Models\AdminUser;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('create:admin', function () {
    AdminUser::create([
        'email' => 'admin@kiaisoft.com',
        'password' => bcrypt('admin@1234'),
    ]);
    $this->info('Account Information:');
    $this->info('ID: admin@kiaisoft.com');
    $this->info('Pass: admin@1234');
})->describe('create an admin account');

Artisan::command('user', function () {
    \App\Models\User::create([
        'username' => 'nguyenduclong',
        'email' => 'long98@email.com',
        'password' => bcrypt('123456789')
    ]);
})->describe('Create sample user');

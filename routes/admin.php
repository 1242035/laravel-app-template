<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:admin')->resource('roles', 'RoleController');
Route::middleware('auth:admin')->resource('permissions', 'PermissionController');
Route::middleware('auth:admin')->resource('users', 'UserController');
Route::middleware('auth:admin')->resource('admins', 'AdminController');
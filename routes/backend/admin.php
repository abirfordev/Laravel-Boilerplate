<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::get('profile', 'DashboardController@profile')->name('profile');
Route::patch('profile/{id}', 'DashboardController@profileUpdate')->name('profile.update');

Route::get('password', 'DashboardController@password')->name('password');
Route::patch('password/{id}', 'DashboardController@passwordUpdate')->name('password.update');


// Routes for Admin
Route::group(
    [
        'controller' => 'AdminController',
        'prefix' => 'settings/admin',
        'as' => 'settings.admin.',
    ],
    function () {
        Route::get('/password/{admin}', 'password')->name('password');
        Route::patch('passwordUpdate/{admin}', 'passwordUpdate')->name('password.update');
        Route::get('/trash', 'trashList')->name('trash');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('restoreSelected/{ids}', 'restoreSelected')->name('restoreSelected');
        Route::delete('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::delete('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
    }
);
Route::resource('settings/admin', 'AdminController');
// --/ Routes for Admin

// Routes for User
Route::group(
    [
        'controller' => 'UserController',
        'prefix' => 'user',
        'as' => 'user.',
    ],
    function () {
        Route::get('/password/{user}', 'password')->name('password');
        Route::patch('passwordUpdate/{user}', 'passwordUpdate')->name('password.update');
        Route::get('/trash', 'trashList')->name('trash');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('restoreSelected/{ids}', 'restoreSelected')->name('restoreSelected');
        Route::delete('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::delete('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
    }
);
Route::resource('user', 'UserController');
// --/ Routes for User

// Routes for Activity Log
Route::get('web-settings/activity-log', 'ActivityLogController@index')->name('activity-log.index');
// --/ Routes for Activity Log

// Routes for Setting
Route::resource('web-settings/setting', 'SettingController');

// --/ Routes for Setting


// Routes for Module
Route::group(
    [
        'controller' => 'ModuleController',
        'prefix' => 'settings/module',
        'as' => 'settings.module.',
    ],
    function () {
        Route::get('/trash', 'trashList')->name('trash');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('restoreSelected/{ids}', 'restoreSelected')->name('restoreSelected');
        Route::delete('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::delete('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
    }
);
Route::resource('settings/module', 'ModuleController');
// --/ Routes for Module

// Routes for Permission
Route::resource('settings/permission', 'PermissionController');
// --/ Routes for Permission

// Routes for Role
Route::group(
    [
        'controller' => 'RoleController',
        'prefix' => 'settings/role',
        'as' => 'settings.role.',
    ],
    function () {
        Route::get('/trash', 'trashList')->name('trash');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('restoreSelected/{ids}', 'restoreSelected')->name('restoreSelected');
        Route::delete('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::delete('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
    }
);
Route::resource('settings/role', 'RoleController');
// --/ Routes for Role

// Routes for Alumni
Route::group(
    [
        'controller' => 'AlumniController',
        'prefix' => 'alumni',
        'as' => 'alumni.',
    ],
    function () {
        Route::get('/password/{alumni}', 'password')->name('password');
        Route::patch('passwordUpdate/{alumni}', 'passwordUpdate')->name('password.update');
        Route::get('/trash', 'trashList')->name('trash');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('restoreSelected/{ids}', 'restoreSelected')->name('restoreSelected');
        Route::delete('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::delete('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
        Route::get('alumniImport/create', 'alumniImportCreate')->name('alumniImport.create');
        Route::post('alumniImport', 'alumniImportStore')->name('alumniImport.store');
    }
);
Route::resource('alumni', 'AlumniController');
// --/ Routes for Alumni
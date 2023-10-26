<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');


// Routes for Admin
Route::group(
    [
        'controller' => 'AdminController',
        'prefix' => 'settings/admin',
        'as' => 'settings.admin.',
    ],
    function () {
        Route::get('/trash', 'trashList')->name('trash');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('restoreSelected/{ids}', 'restoreSelected')->name('restoreSelected');
        Route::get('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::get('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
    }
);
Route::resource('settings/admin', 'AdminController');
// --/ Routes for Admin

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
        Route::get('permanentDelete/{id}', 'permanentDelete')->name('permanentDelete');
        Route::get('permanentDeleteSelected/{ids}', 'permanentDeleteSelected')->name('permanentDeleteSelected');
    }
);
Route::resource('settings/module', 'ModuleController');
// --/ Routes for Module
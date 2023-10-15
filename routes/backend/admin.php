<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

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

<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::get('profile', 'DashboardController@profile')->name('profile');
Route::patch('profile/{id}', 'DashboardController@profileUpdate')->name('profile.update');

Route::get('password', 'DashboardController@password')->name('password');
Route::patch('password/{id}', 'DashboardController@passwordUpdate')->name('password.update');

// Route::patch('change_default_password/{id}', 'DashboardController@change_default_password')->name('change_default_password');
// Route::patch('password/{id}', 'DashboardController@passwordUpdate')->name('password.update');

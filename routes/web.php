<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('frontend.home');
// });

Route::group(
    [
        'namespace' => 'Frontend',
        'as' => 'frontend.'
    ],
    function () {
        require base_path('routes/frontend/home.php');
    }
);


Route::group(
    [
        'namespace' => 'Auth\Admin',
        'prefix' => 'admin',
        'as' => 'admin.',
    ],
    function () {
        Route::get('/login', 'LoginController@login')->name('login');
        Route::post('/loginAdmin', 'LoginController@loginAdmin')->name('loginAdmin');
        Route::get('/logout', 'LoginController@logout')->name('logout');
    }
);

Route::group(
    [
        'namespace' => 'Backend\Admin',
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => 'auth:admin'
    ],
    function () {
        require(base_path('routes/backend/admin.php'));
    }
);


Route::group(
    [
        'namespace' => 'Auth\User',
        'prefix' => 'user',
        'as' => 'user.',
    ],
    function () {
        Route::get('/login', 'LoginController@login')->name('login');
        Route::post('/loginUser', 'LoginController@loginUser')->name('loginUser');
    }
);

Route::group(
    [
        'namespace' => 'Backend\User',
        'prefix' => 'user',
        'as' => 'user.',
        'middleware' => ['auth:user', 'is-set-default-password']
    ],
    function () {
        require(base_path('routes/backend/user.php'));
    }
);

Route::group(
    [
        'prefix' => 'user',
        'as' => 'user.',
        'middleware' => 'auth:user'
    ],
    function () {
        Route::get('logout', 'Auth\User\LoginController@logout')->name('logout');
        Route::patch('change_default_password/{id}', 'Backend\User\DashboardController@change_default_password')->name('change_default_password');
    }
);


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::fallback(function () {
    return view('error.404');
});

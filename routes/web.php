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

Route::get('/', function () {
    return view('welcome');
});


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
        Route::get('/logout', 'LoginController@logout')->name('logout');
    }
);

Route::group(
    [
        'namespace' => 'Backend\User',
        'prefix' => 'user',
        'as' => 'user.',
        'middleware' => 'auth:user'
    ],
    function () {
        require(base_path('routes/backend/user.php'));
    }
);


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::fallback(function () {
    return view('error.404');
});

<?php

use App\Http\Controllers\WEB\PrivacyPolicyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\ScheduleController;
use App\Http\Controllers\WEB\TermOfUseController;
use App\Http\Controllers\WEB\UserController;


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

Route::get('/', function () {
    $array = [
        'status' => true,
        'message' => 'Hello there!...',
        'data' => [
            'service' => 'fitness-api',
            'version' => '1.0',
        ],
    ];
    return response()->json($array);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/term-of-use', [TermOfUseController::class, 'index']);
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index']);

Route::group(['middleware' => ['auth', 'verified']], function() {
    // Route::resource('roles', RoleController::class);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/password', [UserController::class, 'password'])->name('password');
    Route::post('/password/update', [UserController::class, 'passwordUpdate'])->name('newpassword.update');

    //users
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::get('/user/{id}', [UserController::class, 'user'])->name('user');
    // Route::get('/user/schedule/{id}', [UserController::class, 'userSchedule'])->name('user.schedule');

    //schedules
    Route::get('/user/schedule/{id}', [ScheduleController::class, 'userSchedule'])->name('user.schedule');
});

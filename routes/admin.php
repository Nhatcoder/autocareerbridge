<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Management\LoginController;
use App\Http\Controllers\Auth\Management\RegistersController;

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

Route::get('admin', function () {
    return view('management.pages.home');
});

Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
    Route::get('register', [RegistersController::class, 'viewResgister'])->name('register');
    Route::post('postRegister', [RegistersController::class, 'postResgister'])->name('postResgister');

    Route::get('register-confirm', [RegistersController::class, 'registerConfirm'])->name('registerConfirm');
    Route::get('confirm-mail-register', [RegistersController::class, 'confirmMailRegister'])->name('confirmMailRegister');

    Route::get('/', [LoginController::class, 'viewLogin'])->name('login');
    Route::post('check-login', [LoginController::class, 'checkLogin'])->name('checkLogin');
});

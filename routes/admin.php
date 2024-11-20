<?php

use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WorkshopsController;
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


Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
    Route::get('register', [RegistersController::class, 'viewResgister'])->name('register');
    Route::post('postRegister', [RegistersController::class, 'postResgister'])->name('postResgister');
    Route::get('register-confirm', [RegistersController::class, 'registerConfirm'])->name('registerConfirm');
    Route::get('confirm-mail-register', [RegistersController::class, 'confirmMailRegister'])->name('confirmMailRegister');

    Route::get('/', [LoginController::class, 'viewLogin'])->name('login');
    Route::post('check-login', [LoginController::class, 'checkLogin'])->name('checkLogin');
    Route::get('forgot-password', [LoginController::class, 'viewForgotPassword'])->name('forgotPassword');
    Route::post('forgot-password-check', [LoginController::class, 'checkForgotPassword'])->name('checkForgotPassword');
    Route::get('change-password', [LoginController::class, 'viewChangePassword'])->name('viewChangePassword');
    Route::post('post-password', [LoginController::class, 'postPassword'])->name('postPassword');

    Route::post('logout/{id}', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('admin')
    ->as('admin.')
    ->middleware('check.admin')
    ->group(function () {
        Route::get('/', function () {
            return view('management.pages.home');
        })->name('dashboard');
        Route::resource('users', UsersController::class)->except('show');
        Route::resource('jobs', JobsController::class);
        Route::get('jobs/detail/{slug}', [JobsController::class, 'showBySlug'])->name('jobs.slug');
        Route::post('jobs/update-status/', [JobsController::class, 'updateStatus'])->name('jobs.updateStatus');
        Route::resource('workshops', WorkshopsController::class);
        Route::get('workshops/detail/{slug}', [WorkshopsController::class, 'showBySlug'])->name('workshops.slug');

    });

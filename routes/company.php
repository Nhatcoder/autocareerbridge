<?php

use App\Http\Controllers\Company\CompaniesController;
use App\Http\Controllers\Company\HiringsController;
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


Route::group([
    'prefix' => 'company',
    'as' => 'company.',
    'middleware' => 'check.company'
], function () {
    Route::get('/', function () {
        return view('management.pages.company.dashboard.dashBoard');
    })->name('home');

    Route::get('profile', [CompaniesController::class, 'profile'])->name('profile');
    Route::get('profile/edit/{slug}', [CompaniesController::class, 'edit'])->name('profileEdit');
    Route::put('profile/edit/{slug}', [CompaniesController::class, 'updateProfile'])->name('profileUpdate');
    Route::patch('profile/updateAvatar/{slug}', [CompaniesController::class, 'updateImage'])->name('profileUpdateAvatar');
    Route::get('province', [CompaniesController::class, 'getProvinces']);
    Route::get('district/{province_id}', [CompaniesController::class, 'getDistricts']);
    Route::get('ward/{district_id}', [CompaniesController::class, 'getWards']);

    Route::get('manage-hiring', [HiringsController::class, 'index'])->name('manageHiring');
    Route::post('createHiring', [HiringsController::class, 'createHiring'])->name('createHiring');
    Route::get('editHiring/{id}', [HiringsController::class, 'editHiring'])->name('editHiring');
    Route::put('update-hiring', [HiringsController::class, 'updateHiring'])->name('updateHiring');
    Route::delete('deleteHiring/{id}', [HiringsController::class, 'deleteHiring'])->name('deleteHiring');
    Route::get('searchUniversity', [CompaniesController::class, 'searchUniversity'])->name('searchUniversity');
    
});

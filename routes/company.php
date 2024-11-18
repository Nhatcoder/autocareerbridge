<?php

use App\Http\Controllers\HiringsController;
use App\Http\Controllers\CompaniesController;
use App\Models\Company;
use App\Models\Hiring;
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

Route::get('company', function () {
    
});
Route::get('company/manage-hiring', [HiringsController::class, 'index']);
Route::post('company/create-hiring', [HiringsController::class, 'createHiring']);
Route::get('company/edit-hiring/{id}', [HiringsController::class, 'editHiring']);
Route::put('company/update-hiring', [HiringsController::class, 'updateHiring']);
Route::delete('company/delete-hiring/{id}', [HiringsController::class, 'deleteHiring']);
Route::get('/search', [HiringsController::class, 'searchHirings']);
Route::get('company/search-university', [CompaniesController::class,'index']);
Route::get('company/dashboard', function () {
    return view('management.company.dashboard.dashBoard');
});
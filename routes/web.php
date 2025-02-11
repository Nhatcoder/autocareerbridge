<?php

use App\Http\Controllers\Clients\CompaniesController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\JobsController;
use App\Http\Controllers\Clients\ResumeController;
use App\Http\Controllers\Company\CollaborationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Clients\UniversitiesController;
use App\Http\Controllers\Clients\WorkshopsController;

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

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('doanh-nghiep', [CompaniesController::class, 'listCompanies'])->name('listCompany');
    Route::get('doanh-nghiep/{slug}', [CompaniesController::class, 'detailCompany'])->name('detailCompany');
    Route::get('change-language/{language}', [LanguageController::class, 'change'])->name('language.change');
    Route::get('truong-hoc', [UniversitiesController::class, 'listUniversities'])->name('listUniversity');
    Route::get('truong-hoc/{slug}', [UniversitiesController::class, 'showDetailUniversity'])->name('detailUniversity');
    Route::post('collaboration-store', [CollaborationsController::class, 'createRequest'])->name('collaborationStore');
    Route::get('viec-lam/{slug}', [JobsController::class, 'index'])->name('detailJob');
    Route::get('workshop', [HomeController::class, 'workshop'])->name('workshop');
    Route::get('chi-tiet-workshop/{slug}', [WorkshopsController::class, 'index'])->name('detailWorkShop');
    Route::get('viec-lam', [HomeController::class, 'search'])->name('search');

    // cv client
    Route::get('ho-so', [ResumeController::class, 'file'])->name('file');
    Route::get('view-pdf', [ResumeController::class, 'viewPDF'])->name('viewPDF');

    Route::get('mau-cv', [ResumeController::class, 'listCv'])->name('listCv');
    Route::get('my-cv', [ResumeController::class, 'myCv'])->name('myCv');
    Route::get('/cv/create/{template}', [ResumeController::class, 'createCV'])->name('cv.create');

    Route::get('cv/{id}/download', [ResumeController::class, 'download'])->name('cv.download');
    Route::get('cv/{id}/view', [ResumeController::class, 'view'])->name('cv.view');
    Route::get('cv/{id}/edit', [ResumeController::class, 'editCV'])->name('cv.edit');

    Route::get('/api/cv/{id}', [ResumeController::class, 'getCVData']);



    // thêm thông tin cập nhật hồ sơ
    // Route::get('cap-nhat-cv/{id}', [ResumeController::class, 'edit'])->name('editCv');
    Route::post('cv/create', [ResumeController::class, 'store'])->name('createCv');
    Route::put('cv/{id}/update', [ResumeController::class, 'update'])->name('updateCv');
});

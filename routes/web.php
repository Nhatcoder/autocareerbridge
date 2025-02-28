<?php

use App\Http\Controllers\Auth\Custommer\CustommerController;
use App\Http\Controllers\Clients\ConversationsController;
use App\Http\Controllers\Clients\CompaniesController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\JobsController;
use App\Http\Controllers\Clients\ResumeController;
use App\Http\Controllers\Company\CollaborationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Clients\UniversitiesController;
use App\Http\Controllers\Clients\WorkshopsController;
use App\Http\Controllers\NotificationsController;

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
    Route::get('lich-su-ung-tuyen', [HomeController::class, 'historyJobApply'])->name('historyJobApply');

    Route::middleware('check.login')
        ->group(function () {
            // cv client
            Route::get('ho-so', [ResumeController::class, 'file'])->name('file');
            Route::get('view-pdf', [ResumeController::class, 'viewPDF'])->name('viewPDF');

            Route::get('mau-cv', [ResumeController::class, 'listCv'])->name('listCv');
            Route::get('my-cv', [ResumeController::class, 'myCv'])->name('myCv');
            Route::get('/cv/create', [ResumeController::class, 'createCV'])->name('cv.create');

            Route::get('cv/{id}/download', [ResumeController::class, 'download'])->name('cv.download');
            Route::get('cv/{id}/view', [ResumeController::class, 'view'])->name('cv.view');
            Route::get('cv/{id}/edit', [ResumeController::class, 'editCV'])->name('cv.edit');
            Route::delete('cv/{id}/delete', [ResumeController::class, 'deleteCv'])->name('cv.delete');
            Route::get('/api/cv/{id}', [ResumeController::class, 'getCVData']);

            // thêm thông tin cập nhật hồ sơ
            // Route::get('cap-nhat-cv/{id}', [ResumeController::class, 'edit'])->name('editCv');
            Route::post('cv/create', [ResumeController::class, 'store'])->name('createCv');
            Route::put('cv/{id}/update', [ResumeController::class, 'update'])->name('updateCv');

            Route::post('cv/upload', [ResumeController::class, 'uploadStoreCv'])->name('cv.upload.store');
            Route::get('cv/upload', [ResumeController::class, 'uploadCv'])->name('cv.upload');

            Route::get('cv/upload/{id}/view', [ResumeController::class, 'uploadCvView'])->name('cv.upload.view');
            Route::get('cv/upload/{id}/down', [ResumeController::class, 'downloadUploadedCv'])->name('cv.upload.down');

            Route::put('cv/upload/{id}/update', [ResumeController::class, 'updateTitleCv'])->name('cv.upload.update');

            Route::get('load-template/{template}', function ($template) {
                return view('client.pages.cv.all.' . $template)->render();
            });
            Route::put('/cv/{id}/change', [ResumeController::class, 'changeCvTemplate'])->name('cv.change');

            Route::post('apply-job', [JobsController::class, 'applyJob'])->name('applyJob');

            Route::get('tro-truyen/{id?}', [ConversationsController::class, 'conversations'])->name('conversations');
            Route::post('chat-store', [ConversationsController::class, 'chatStore'])->name('chatStore');
            Route::get('history-file/{id}', [ConversationsController::class, 'historyFile'])->name('historyFile');
            Route::get('history-image/{id}', [ConversationsController::class, 'historyImage'])->name('historyImage');
            Route::get('user-chat', [ConversationsController::class, 'getUserChat'])->name('getUserChat');
            Route::get('update-seen-message', [ConversationsController::class, 'updateSeenMessage'])->name('updateSeenMessage');

            Route::get('get-data-scroll-notifycation', [NotificationsController::class, 'getDataScrollNotifycation'])->name('getDataScrollNotifycation');
        });

    Route::middleware('check.login')
        ->group(function () {
            Route::get('dang-ky', [CustommerController::class, 'viewRegister'])->name('viewRegister');
            Route::get('dang-nhap', [CustommerController::class, 'viewLogin'])->name('viewLogin');
            Route::post('register', [CustommerController::class, 'register'])->name('register');
            Route::post('login', [CustommerController::class, 'login'])->name('login');
            Route::post('logout', [CustommerController::class, 'logout'])->name('logout');
            Route::get('login-by-google', [CustommerController::class, 'viewLoginWithGoogle'])->name('viewLoginWithGoogle');
            Route::get('login-google/callback', [CustommerController::class, 'loginWithGoogle'])->name('loginWithGoogle');

            Route::prefix('tai-khoan')
                ->as('account.')
                ->group(function () {
                    Route::get('/', [CustommerController::class, 'profile'])->name('profile');
                    Route::post('update', [CustommerController::class, 'updateProfile'])->name('updateProfile');
                    Route::post('update-avatar', [CustommerController::class, 'updateAvatar'])->name('updateAvatar');
                    Route::get('mat-khau', [CustommerController::class, 'changePasswordForm'])->name('changePasswordForm');
                    Route::post('updatePassword', [CustommerController::class, 'updatePassword'])->name('updatePassword');
                });
        });
});

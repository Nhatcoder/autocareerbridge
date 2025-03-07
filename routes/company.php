<?php

use App\Http\Controllers\Company\CollaborationsController;
use App\Http\Controllers\Company\CompaniesController;
use App\Http\Controllers\Company\HiringsController;
use App\Http\Controllers\Company\JobsController;
use App\Http\Controllers\Company\MajorsController;
use App\Http\Controllers\Company\ScheduleInterviewController;
use App\Http\Controllers\University\WorkShopsController;
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
    'middleware' => ['check.company', 'check.company.isEmpty']
], function () {
    Route::get('/', [CompaniesController::class, 'dashboard'])->name('home');
    Route::post('get-job-chart', [CompaniesController::class, 'getJobChart'])->name('getJobChart');
    Route::get('profile', [CompaniesController::class, 'profile'])->name('profile');
    Route::get('profile/edit/{slug}', [CompaniesController::class, 'edit'])->name('profileEdit');
    Route::put('profile/edit/{slug}', [CompaniesController::class, 'updateProfile'])->name('profileUpdate');

    Route::get('manage-hiring', [HiringsController::class, 'index'])->name('manageHiring');
    Route::get('manage-hiring/create', [HiringsController::class, 'create'])->name('create');
    Route::post('manage-hiring/store', [HiringsController::class, 'store'])->name('store');
    Route::get('manage-hiring/edit/{id}', [HiringsController::class, 'edit'])->name('editHiring');
    Route::put('manage-hiring/update/{userId}', [HiringsController::class, 'update'])->name('updateHiring');
    Route::delete('manage-hiring/delete/{id}', [HiringsController::class, 'deleteHiring'])->name('deleteHiring');
    Route::get('search-university', [CompaniesController::class, 'searchUniversity'])->name('searchUniversity');

    Route::get('manage-collaboration', [CollaborationsController::class, 'index'])->name('collaboration');

    Route::get('/major', [MajorsController::class, 'index'])->name('majorCompany');
    Route::get('/major/create', [MajorsController::class, 'create'])->name('createMajorCompany');
    Route::post('/major/store', [MajorsController::class, 'store'])->name('storeMajorCompany');
    Route::delete('/major/delete/{majorId}', [MajorsController::class, 'delete'])->name('deleteMajorCompany');
    Route::post('collaboration/change-status', [CollaborationsController::class, 'changeStatus'])->name('changeStatusColab');
    Route::delete('collaboration/delete/{id}', [CollaborationsController::class, 'delete'])->name('collaboration.delete');

    Route::get('schedule-interviews', [ScheduleInterviewController::class, 'index'])->name('scheduleInterview');
    Route::post('schedule-interviews-store', [ScheduleInterviewController::class, 'scheduleInterviewStore'])->name('scheduleInterviewStore');
    Route::post('delete-schedule-interview', [ScheduleInterviewController::class, 'deleteScheduleInterview'])->name('deleteScheduleInterview');
    Route::get('schedule-interviews-all', [ScheduleInterviewController::class, 'refreshEvents'])->name('refreshEvents');
    Route::get('getAllJobInterview', [ScheduleInterviewController::class, 'getAllJobInterview'])->name('getAllJobInterview');

    // Route::get('/schedule-interviews', [ScheduleInterviewController::class, 'index'])->name('schedule-interviews.list');
    // Route::get('/schedule-interviews/get-data', [ScheduleInterviewController::class, 'getData'])->name('schedule-interviews.data');
    Route::get('/schedule-interviews/{id}/attendees', [ScheduleInterviewController::class, 'getAttendees'])->name('schedule-interviews.attendees');
    Route::get('/schedule-interviews/{id}/edit', [ScheduleInterviewController::class, 'edit'])->name('schedule-interviews.edit');
    Route::put('/schedule-interviews/{id}', [ScheduleInterviewController::class, 'update'])->name('schedule-interviews.update');

    Route::get('/api/gg-calendar/{eventId}', [ScheduleInterviewController::class, 'getGoogleCalendarEvent'])->name('gg-calendar.eventId');
    Route::get('get-user-apply-job', [ScheduleInterviewController::class, 'getUserJob'])->name('getUserJob');
});

Route::group([
    'prefix' => 'company',
    'as' => 'company.',
    'middleware' => ['check.hiring.or.company'],
], function () {
    Route::get('manage-job', [JobsController::class, 'index'])->name('manageJob');
    Route::get('manage-job/create', [JobsController::class, 'create'])->name('createJob');
    Route::post('manage-job/store', [JobsController::class, 'store'])->name('storeJob');
    Route::get('manage-job/edit/{slug}', [JobsController::class, 'edit'])->name('editJob');
    Route::put('manage-job/update/{id}', [JobsController::class, 'update'])->name('updateJob');
    Route::delete('manage-job/delete/{id}', [JobsController::class, 'destroy'])->name('deleteJob');
    Route::get('manage-job/detail/{slug}', [JobsController::class, 'show'])->name('showJob');
    Route::get('manage-university-job', [JobsController::class, 'manageUniversityJob'])->name('manageUniversityJob');
    Route::get('manage-user-job', [JobsController::class, 'manageUserApplyJob'])->name('manageUserApplyJob');
    Route::get('user-job/check-seen', [JobsController::class, 'checkUserJobSeen'])->name('checkUserJobSeen');
    Route::post('user-job/seen-cv', [JobsController::class, 'seenCvUserJob'])->name('seenCvUserJob');
    Route::post('manage-user-job/change-status', [JobsController::class, 'changeStatusUserAplly'])->name('changeStatusUserAplly');
    Route::get('manage-university-job/change-status/{id}/{status}', [JobsController::class, 'updateStatus'])->name('updateStatus');
    Route::post('workshop/apply/{companyId}/{workshopId}', [WorkShopsController::class, 'applyWorkshop'])->name('workshop.apply');
    Route::get('/workshops/applied', [WorkShopsController::class, 'workshopApplied'])->name('workshops.applied');

    Route::get('jobs/applicants/{job}', [JobsController::class, 'getUserApplyJob'])->name('getUserApplyJob');
});
Route::get('/google/redirect', [ScheduleInterviewController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/callback', [ScheduleInterviewController::class, 'handleGoogleCallback'])->name('google.callback');

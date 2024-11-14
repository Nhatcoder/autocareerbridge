<?php

use App\Http\Controllers\University\StudentsController;
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

Route::get('unviersity', function () {
    echo "Dai hoc";
});

Route::prefix('unviersity')
    ->as('unviersity.')
    ->group(function () {
        Route::resource('students', StudentsController::class);
    });
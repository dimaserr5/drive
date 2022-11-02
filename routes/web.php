<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\fileInfoController;
use App\Http\Controllers\files\filesController;
use App\Http\Controllers\profile\profileController;
use App\Http\Controllers\public_file\publicFileController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::get('/public_file/{file}',[publicFileController::class, 'get'])->name('publicfile');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [dashboardController::class, 'getPage'])->name('dashboard');
    Route::get('/dashboard/{folder}', [dashboardController::class, 'getPageFolder'])->name('dashboardfolder');

    Route::get('/profile', [profileController::class, 'get'])->name('profile');

    Route::post('/dashboard/add',[dashboardController::class, 'add'])->name('dashboard/add');
    Route::post('/dashboard/addfolder',[dashboardController::class, 'addfolder'])->name('dashboard/addfolder');

    Route::get('/file_info/{id}',[fileInfoController::class, 'file_info'])->name('fileinfo');
    Route::post('/file_info/editname',[filesController::class, 'editname'])->name('editfilename');
    Route::post('/file_info/deletefile',[filesController::class, 'deletefile'])->name('deletefile');
    Route::post('/file_info/sharefile',[filesController::class, 'sharefile'])->name('sharefile');



});

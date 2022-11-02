<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\fileInfoController;
use App\Http\Controllers\files\filesController;
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

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [dashboardController::class, 'getPage'])->name('dashboard');

    Route::post('/dashboard/add',[dashboardController::class, 'add'])->name('dashboard/add');
    Route::post('/dashboard/addfolder',[dashboardController::class, 'addfolder'])->name('dashboard/addfolder');

    Route::get('/file_info/{id}',[fileInfoController::class, 'file_info'])->name('fileinfo');
    Route::post('/file_info/editname',[filesController::class, 'editname'])->name('editfilename');

});

<?php

use App\Http\Controllers\api\userInfoController;
use App\Models\user\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*route::middleware('auth_api')->get('/user/{id}',function (Request $request, $id){
    $user = userModel::getUser($id);
    if(!$user['id']) return response('',404);
    return $user;
});*/

Route::middleware('auth_api')->group(function () {

    Route::get('/user', [userInfoController::class, 'getUser'])->name('api/user');

    Route::get('/user/files', [userInfoController::class, 'getUserFiles'])->name('api/user/files');
    Route::get('/user/files/info', [userInfoController::class, 'getUserFilesInfo'])->name('api/user/files/info');

});

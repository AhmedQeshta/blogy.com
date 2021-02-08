<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
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


//
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::get('post/all', [AuthController::class, 'AllPosts']);
Route::group(['prefix' => 'user', 'middleware' => ['assign.guard:api', 'jwt.auth']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});


//admin
Route::post('admin/login', [AdminController::class, 'loginAsAdmin']);
Route::group(['prefix' => 'admin', 'middleware' => ['assign.guard:api-admin', 'jwt.auth']], function () {
    Route::get('AdminInformation', [AdminController::class, 'AdminInformation']);
    Route::post('post/create', [AdminController::class, 'createPost']);
    Route::get('post/all', [AdminController::class, 'getPosts']);
    Route::get('post/delete/{id}', [AdminController::class, 'deletePost']);
    Route::post('post/update/{id}', [AdminController::class, 'updatePost']);
    Route::get('post/show/{id}', [AdminController::class, 'showPost']);

    Route::post('logout', [AdminController::class, 'logoutAsAdmin']);
});

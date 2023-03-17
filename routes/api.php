<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;
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
// Route::middleware('auth:sanctum')->get('/user',function (Request $request) {
//    return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('getAll', [AuthController::class, 'getAll']);

});

Route::group(['middleware' => ['language', 'token']], function () {

    Route::get('subCategory/getAll', [SubCategoryController::class, 'getAll']);
    Route::get('subCategory/getById/{id}', [SubCategoryController::class, 'getById']);

});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::put('update', [AuthController::class, 'update']);
Route::delete('delete/{id}', [AuthController::class, 'delete']);
Route::post('restore/{id}', [AuthController::class, 'restore']);

// Route::get('getAll', [AuthController::class, 'getAll']);
Route::get('getDeletedUser', [AuthController::class, 'getDeletedUser']);

Route::post('uploadFile', [AuthController::class, 'uploadFile']);

// categories 
Route::post('category/create', [CategoryController::class, 'create']);
Route::post('category/update/{id}', [CategoryController::class, 'update']);
Route::delete('category/delete/{id}', [CategoryController::class, 'delete']);
Route::post('category/restore/{id}', [CategoryController::class, 'restore']);
Route::get('category/getAll', [CategoryController::class, 'getAll']);
Route::get('category/getSubCategories/{id}', [CategoryController::class, 'getSubCategories']);
Route::get('category/getById/{id}', [CategoryController::class, 'getById']);


// sub categories 
Route::post('subCategory/create', [SubCategoryController::class, 'create']);
// Route::post('category/update/{id}', [SubCategoryController::class, 'update']);
// Route::delete('category/delete/{id}', [SubCategoryController::class, 'delete']);
// Route::post('category/restore/{id}', [SubCategoryController::class, 'restore']);

// Route::get('subCategory/getAll', [SubCategoryController::class, 'getAll']);
// Route::get('subCategory/getById/{id}', [SubCategoryController::class, 'getById']);

Route::post('subCategory/uploadImage', [SubCategoryController::class, 'uploadImage']);
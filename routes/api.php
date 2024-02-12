<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', \App\Http\Controllers\Auth\AuthController::class)->name('api.login');
Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('api.register');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/upload/photos', [\App\Http\Controllers\Fichiers\ImageController::class, 'upload']);

    Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);
});

Route::get('/images', [\App\Http\Controllers\Fichiers\ImageController::class, 'getListe']);


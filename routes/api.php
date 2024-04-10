<?php

use App\Http\Controllers\Fichiers\ImageController;
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
Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('api.logout');
Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('api.register');


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);
    Route::post('/tag/store', [\App\Http\Controllers\Tags\TagsController::class, 'store']);

    Route::put('/photo/update', [\App\Http\Controllers\Fichiers\ImageController::class, 'update']);


    Route::get('/messages', [\App\Http\Controllers\Message\MessageController::class, 'getMessages']);
    Route::get('/message/archived', [\App\Http\Controllers\Message\MessageController::class, 'getArchivedMessages']);
    Route::post('/message/read', [\App\Http\Controllers\Message\MessageController::class, 'read']);
    Route::post('/message/archive', [\App\Http\Controllers\Message\MessageController::class, 'archive']);
    Route::post('/message/delete', [\App\Http\Controllers\Message\MessageController::class, 'delete']);
});

Route::post('/upload/photos', [\App\Http\Controllers\Fichiers\ImageController::class, 'uploadAndStore']);
Route::post('/upload/videos', [\App\Http\Controllers\Fichiers\VideosController::class, 'upload']);


Route::get('/photos', [\App\Http\Controllers\Fichiers\ImageController::class, 'getListe']);
Route::get('/photosWithTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosWithTags']);
Route::get('/photosByTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosByTags']);
Route::get('/get30RandomPhotosWithTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'get30RandomPhotosWithTags']);

Route::post('/message/send', [\App\Http\Controllers\Message\MessageController::class, 'send']);

Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);

Route::post('/newsletter/subscribe', [\App\Http\Controllers\Newsletter\NewsletterController::class, 'subscribe']);


<?php

use Illuminate\Support\Facades\Route;

Route::post('login', \App\Http\Controllers\Auth\AuthController::class)->name('api.login');
Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('api.logout');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/sync/images', [\App\Http\Controllers\Sync\SyncController::class, 'syncImages']);
    Route::post('/sync/videos', [\App\Http\Controllers\Sync\SyncController::class, 'syncVideos']);

    Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);
    Route::post('/tag/store', [\App\Http\Controllers\Tags\TagsController::class, 'store']);

    Route::put('/photo/update', [\App\Http\Controllers\Fichiers\ImageController::class, 'update']);
    Route::put('/video/update', [\App\Http\Controllers\Fichiers\VideosController::class, 'update']);

    Route::get('/messages', [\App\Http\Controllers\Message\MessageController::class, 'getMessages']);
    Route::get('/message/archived', [\App\Http\Controllers\Message\MessageController::class, 'getArchivedMessages']);
    Route::post('/message/read', [\App\Http\Controllers\Message\MessageController::class, 'read']);
    Route::post('/message/archive', [\App\Http\Controllers\Message\MessageController::class, 'archive']);
    Route::post('/message/delete', [\App\Http\Controllers\Message\MessageController::class, 'delete']);
});

Route::get('/photosWithTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosWithTags']);
Route::get('/photosByTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosByTags']);
Route::get('/get30RandomPhotosWithTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'get30RandomPhotosWithTags']);
Route::get('/getPhotosSortedByTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosSortedByTags']);

Route::get('/videosWithTags', [\App\Http\Controllers\Fichiers\VideosController::class, 'getVideosWithTags']);
Route::get('/videosByTags', [\App\Http\Controllers\Fichiers\VideosController::class, 'getVideoByTags']);
Route::get('/get30RandomVideosWithTags', [\App\Http\Controllers\Fichiers\VideosController::class, 'get30RandomVideosWithTags']);

Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);

Route::post('/message/send', [\App\Http\Controllers\Message\MessageController::class, 'send']);
Route::post('/newsletter/subscribe', [\App\Http\Controllers\Newsletter\NewsletterController::class, 'subscribe']);

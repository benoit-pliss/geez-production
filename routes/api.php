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
Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('api.logout');
Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('api.register');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/upload/photos', [\App\Http\Controllers\Fichiers\ImageController::class, 'upload']);

    Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);
    Route::post('/tag/store', [\App\Http\Controllers\Tags\TagsController::class, 'store']);

    Route::put('/photo/update', [\App\Http\Controllers\Fichiers\ImageController::class, 'update']);


});

Route::get('/photos', [\App\Http\Controllers\Fichiers\ImageController::class, 'getListe']);
Route::get('/photosWithTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosWithTags']);
Route::get('/photosByTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'getPhotosByTags']);
Route::get('/get30RandomPhotosWithTags', [\App\Http\Controllers\Fichiers\ImageController::class, 'get30RandomPhotosWithTags']);

Route::get('/tags', [\App\Http\Controllers\Tags\TagsController::class, 'getTags']);

Route::post('/newsletter/subscribe', [\App\Http\Controllers\Newsletter\NewsletterController::class, 'subscribe']);

Route::post('/contact/send', [\App\Http\Controllers\Message\MessageController::class, 'send']);
Route::get('/messages', [\App\Http\Controllers\Message\MessageController::class, 'getMessages']);
Route::get('/message/archived', [\App\Http\Controllers\Message\MessageController::class, 'getArchivedMessages']);
Route::post('/message/read', [\App\Http\Controllers\Message\MessageController::class, 'read']);
Route::post('/message/archive', [\App\Http\Controllers\Message\MessageController::class, 'archive']);
Route::post('/message/delete', [\App\Http\Controllers\Message\MessageController::class, 'delete']);

Route::get('/videos/{file_name}', function ($file_name) {
    $path = storage_path('app/public/videos/' . $file_name);
    $url = env('APP_URL') . '/storage/videos/' . $file_name;
    $videos = [];

    foreach (scandir($path) as $file) {
        if (in_array($file, ['.', '..'])) {
            continue;
        }
        // ignore .DS_Store file
        if ($file === '.DS_Store') {
            continue;
        }

        $videos[] = [
            'name' => $file,
            'size' => filesize($path . '/' . $file),
            'type' => mime_content_type($path . '/' . $file),
            'url' => $url . '/' . $file,
        ];
    }

    return response()->json([
        'success' => true,
        'videos' => $videos,
    ]);
});

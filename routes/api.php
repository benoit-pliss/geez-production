<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Fruitcake\Cors\CorsService;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload', function (Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $file = $request->file('image');
    $originalName = $file->getClientOriginalName();
    $path = $file->storeAs('public/images', $originalName);

    return response()->json([
        'success' => true,
        'path' => $path,
    ]);
});

Route::get('/images', function () {
    $path = storage_path('app/public/images');
    $url = env('APP_URL') . '/storage/images';
    $images = [];

    foreach (scandir($path) as $file) {
        if (in_array($file, ['.', '..'])) {
            continue;
        }

        $images[] = [
            'name' => $file,
            'size' => filesize($path . '/' . $file),
            'type' => mime_content_type($path . '/' . $file),
            'url' => $url . '/' . $file,
        ];
    }

    return response()->json([
        'success' => true,
        'images' => $images,
    ]);
});

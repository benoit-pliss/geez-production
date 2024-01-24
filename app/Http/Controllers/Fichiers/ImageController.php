<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Images;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request) {
        $request->validate([
            'images' => 'requiredd|array',
        ]);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('public/images', $originalName);


        if (!(Images::class::where('name', $originalName)->exists())) {
            $image = Images::class::create([
                'name' => $originalName,
                'description' => null,
                'type' => $file->getMimeType(),
                'url' => env('APP_URL') . '/storage/images/' . $originalName,
            ]);
        } else {
            $image = Images::class::where('name', $originalName)->first();
            return response()->json([
                'success' => false,
                'message' => 'Image already exists',
                'entity' => $image,
            ]);
        }

        return response()->json([
            'success' => true,
            'entity' => $image,
        ]);
    }

    public function getListe() {
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
    }

}

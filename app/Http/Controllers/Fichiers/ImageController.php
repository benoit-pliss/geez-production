<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Images;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'photos' => 'required',
        ]);


        $images = $request->get('photos');


        Log::info($images);
        foreach ($images as $image) {
            Log::info($image);
            self::storeImage($image);

        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded',
        ]);

    }

    public function storeImage($image): JsonResponse
    {
        try {
            $entity = Images::class::create([
                'name' => $image['name'],
                'description' => $image['description'],
                'url' => env('APP_URL') . '/storage/images/' . $image['name'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded',
                'entity' => $entity,
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while uploading the image. Please make sure the image name is unique.',
                ], 400);
            }

            throw $e;
        }
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

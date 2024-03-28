<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideosController extends Controller
{

    public function upload(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('public/videos', $originalName);

        if (Files::class::where('name', $originalName)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette video existe déjà en base de données.',
            ], 400);
        }

        $video = Files::class::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'description' => $request->input('description'),
            'url' => env('APP_URL') . '/storage/videos/' . $originalName,
            'poster_url' => $request->input('poster_url'),
        ], 200);

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $tagsArray = json_decode($tags, true);
            foreach ($tagsArray as $tag) {
                $video->tags()->attach($tag['id'], ['file_id' => $video['id'], 'tag_id' => $tag['id']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded',
            'entity' => $video,
        ]);
    }

}

<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\FilesTags;
use App\Models\Tags;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function upload(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);


        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('public/images', $originalName);


        if (Files::class::where('name', $originalName)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette image existe déjà en base de données.',
            ], 400);
        }

        $image = Files::class::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'description' => $request->input('description'),
            'url' => env('APP_URL') . '/storage/images/' . $originalName,
        ], 200);

        if ($request->has('tags')) {

            $tags = $request->input('tags');
            $tagsArray = json_decode($tags, true);
            foreach ($tagsArray as $tag) {
                $image->tags()->attach($tag['id'], ['file_id' => $image['id'], 'tag_id' => $tag['id']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded',
            'entity' => $image,
        ]);
    }

    public function getListe() {
        return response()->json([
            'success' => true,
            'message' => 'Liste des images',
            'photos' => Files::all(),
        ]);
    }

    public function getPhotosWithTags(Request $request) : JsonResponse
    {
        $searchName = $request->input('searchName');

        $photos = Files::with('tags')
            ->when($searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Liste des images avec tags',
            'photos' => $photos,
        ]);
    }

    public function get30RandomPhotosWithTags() : JsonResponse
    {
        $photos = Files::with('tags')->inRandomOrder()->limit(30)->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des 30 images aléatoires avec tags',
            'photos' => $photos,
        ]);
    }

    public function getPhotosByTags(Request $request) : JsonResponse
    {

        $request->validate([
            'tags' => 'required|array',
        ]);

        $tags = $request->input('tags');
        $images = Files::with('tags')->whereHas('tags', function($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        })->get();


        return response()->json([
            'success' => true,
            'message' => 'Liste des images par tag',
            'photos' => $images,
        ]);

    }

    public function update(Request $request) : JsonResponse
    {
        Log::info($request);
        $request->validate([
            'id' => 'required|integer',
        ]);

        $image = Files::findOrFail($request->input('id'));

        $image->update($request->all());

        if ($request->has('tags') && $request->input('tags') !== null) {
            $tags = $request->input('tags');
            $tagsArray = array_map(function($tag) {
                return $tag['id'];
            }, $tags);

            $image->tags()->sync($tagsArray);
        }

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully',
            'image' => $image
        ]);
    }

}

<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadAndStore(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $basename = pathinfo($originalName, PATHINFO_FILENAME);

        if (Files::where('name', $basename)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette image existe déjà en base de données.',
            ], 400);
        }

        $uploaded = cloudinary()->upload($file->getRealPath(), [
            'folder'    => 'geez-production/images',
            'public_id' => $basename,
            'format'    => 'webp',
            'quality'   => 'auto',
        ]);

        $image = FilesController::storeFileOnDatabase(
            $originalName,
            $uploaded->getSecurePath(),
            $request->input('description'),
            null
        );

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $tagsArray = json_decode($tags, true);
            foreach ($tagsArray as $tag) {
                $image->tags()->attach($tag['id'], ['file_id' => $image['id'], 'tag_id' => $tag['id']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded and stored successfully',
            'entity' => $image,
        ]);
    }



    public function getListe() {
        return response()->json([
            'success' => true,
            'message' => 'Liste des images',
            'photos' => Files::all()->where('id_type', 1),
        ]);
    }

    public function getPhotosWithTags(Request $request) : JsonResponse
    {
        $searchName = $request->input('searchName');

        $photos = Files::where(['id_type' => 1])
            ->when($searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->with(['tags' => function ($query) {
                $query->orderBy('name');
            }])
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Liste des images avec tags',
            'photos' => $photos,
        ]);
    }

    public function get30RandomPhotosWithTags() : JsonResponse
    {
        $photos = Files::with(['tags' => function ($query) {
            $query->orderBy('name');
        }])->where('id_type', 1)->inRandomOrder()->limit(30)->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des 30 images aléatoires avec tags',
            'photos' => FilesController::sortedFilesListe($photos),
        ]);
    }

    public function getPhotosByTags(Request $request) : JsonResponse
    {

        $request->validate([
            'tags' => 'required|array',
        ]);

        $tags = $request->input('tags');
        $images = Files::with(['tags' => function ($query) {
            $query->orderBy('name');
        }])->where('id_type', 1)->whereHas('tags', function($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        })->get();


        return response()->json([
            'success' => true,
            'message' => 'Liste des images par tag',
            'photos' => FilesController::sortedFilesListe($images),
        ]);

    }

    public function getPhotosSortedByTags() : JsonResponse
    {
        $photos = Files::with(['tags' => function ($query) {
            $query->orderBy('name');
        }])
            ->where('id_type', 1)
            ->get();

        // Tri des photos par le nom du premier tag
        $sortedPhotos = $photos->sortBy(function ($photo) {
            return $photo->tags->first()->name ?? null;
        });

        return response()->json([
            'success' => true,
            'message' => 'Liste des images triées par tags',
            'photos' => $sortedPhotos->values()->all(),
        ]);
    }

    public function update(Request $request) : JsonResponse
    {
        // Valider les données de la requête
        Log::info($request);
        $request->validate([
            'id' => 'required|integer',
            // Ajoutez ici d'autres champs si nécessaire
        ]);

        // Trouver l'image par son ID
        $image = Files::findOrFail($request->input('id'));

        // Mettre à jour l'image avec les nouvelles données
        $image->update($request->all());

        if ($request->has('tags') && $request->input('tags') !== null) {
            $tags = $request->input('tags');
            $tagsArray = array_map(function($tag) {
                return $tag['id'];
            }, $tags);

            // Supprimer tous les tags actuels de l'image et ajouter les nouveaux tags
            $image->tags()->sync($tagsArray);
        }

        // Retourner une réponse
        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully',
            'image' => $image
        ]);
    }


    public function uploadAndStoreThumbnail(Request $request) : JsonResponse
    {
        $request->validate([
            'videoName' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $uploaded = cloudinary()->upload($request->file('file')->getRealPath(), [
            'folder'    => 'geez-production/posters',
            'public_id' => $request->input('videoName'),
            'format'    => 'webp',
            'quality'   => 'auto',
        ]);

        $video = Files::where(['name' => $request->input('videoName'), 'id_type' => 2])->first();
        $video->update(['poster_url' => $uploaded->getSecurePath()]);

        return response()->json([
            'success' => true,
            'message' => 'Thumbnail uploaded and stored successfully',
            'url' => $video,
        ]);
    }

}

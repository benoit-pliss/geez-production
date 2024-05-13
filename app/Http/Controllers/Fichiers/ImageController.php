<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Psy\Util\Json;

class ImageController extends Controller
{
    public function uploadAndStore(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME) . '.webp';

        // Vérifiez si l'image existe déjà en base de données
        if (Files::class::where('name', pathinfo($originalName, PATHINFO_FILENAME))->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette image existe déjà en base de données.',
            ], 400);
        }

        // Convertir l'image en WEBP et la stocker sur le serveur FTP
        $manager = new ImageManager(array('driver' => 'gd'));
        $image = $manager->make($file)->encode('webp', 75);

        FilesController::storeFileOnServer($image, $filename, 'images');

        // Enregistrez l'URL en base de données
        $image = FilesController::storeFileOnDatabase(
            $originalName,
            env('DATA_URL') . '/images/' . $filename,
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

        $photos = Files::with('tags')->where('id_type', 1)
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
        $photos = Files::with('tags')->where('id_type', 1)->inRandomOrder()->limit(30)->get();

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
        $images = Files::with('tags')->where('id_type', 1)->whereHas('tags', function($query) use ($tags) {
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

        $manager = new ImageManager(array('driver' => 'gd'));
        $image = $manager->make($request->file('file'))->encode('webp', 75);
        $url = FilesController::storeFileOnServer($image, $request->input('videoName'), 'posters');

        $video = Files::class::where(['name' => $request->input('videoName'), 'id_type' => 2])->first();
        $video->update(['poster_url' => $url]);

        return response()->json([
            'success' => true,
            'message' => 'Thumbnail uploaded and stored successfully',
            'url' => $video,
        ]);
    }

}

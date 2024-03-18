<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\FilesTags;
use App\Models\Images;
use App\Models\Tags;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadAndStore(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = time().'_'.$originalName;

        // Vérifiez si l'image existe déjà en base de données
        if (Images::class::where('name', pathinfo($originalName, PATHINFO_FILENAME))->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette image existe déjà en base de données.',
            ], 400);
        }

        // Stocker l'image sur le serveur FTP
        Storage::disk('ftp')->put('images/'.$filename, file_get_contents($file), 'public');

        // Enregistrez l'URL en base de données
        $image = Images::class::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'description' => $request->input('description'),
            'url' => env('DATA_URL') . '/images/' . $filename,
        ]);

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
            'photos' => Images::all(),
        ]);
    }

    public function getPhotosWithTags(Request $request) : JsonResponse
    {
        $searchName = $request->input('searchName');

        $photos = Images::with('tags')
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
        $photos = Images::with('tags')->inRandomOrder()->limit(30)->get();

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
        $images = Images::with('tags')->whereHas('tags', function($query) use ($tags) {
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
        $image = Images::findOrFail($request->input('id'));

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

    public function storeV2(Request $request)
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time().'_'.$photo->getClientOriginalName();

            // Stocker dans le dossier spécifié dans 'root' dans le fichier de configuration
            Storage::disk('ftp')->put($filename, file_get_contents($photo), 'public');

            $entity = Images::class::create([
                'name' => $filename,
                'description' => $request->input('description'),
                'url' => env('DATA_URL') . '/images/' . $filename,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully',
                'url' => Storage::disk('ftp')->url($filename),
                'url2' => env('DATA_URL') . '/images/' . $filename,
                'entity' => $entity,
            ], 200);
        }

        return response()->json(['message' => 'No photo uploaded'], 400);
    }

    public function testFtpConnection() : JsonResponse
    {
        try {
            // Remplacez 'filename.txt' par un fichier que vous savez exister sur le serveur FTP
            $exists = Storage::disk('ftp')->exists('test.jpg');

            if ($exists) {
                return response()->json([
                    'success' => true,
                    'message' => 'FTP connection successful',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'FTP connection failed',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'FTP connection failed: ' . $e->getMessage(),
            ], 500);
        }
    }

}

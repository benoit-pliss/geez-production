<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Jobs\Videos\AssembleFileJob;
use App\Models\Files;
use FFMpeg\FFMpeg;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\ContentRangeUploadHandler;

class VideosController extends Controller
{

    public function getFirstFrame($videoFile, $originalName) : string
    {
        // Create an instance of FFMpeg and open the video
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoFile);

        // Extract the first frame of the video
        $frame = $video->frame(TimeCode::fromSeconds(1));


        // Define the name and path for the image
        $imageName = pathinfo($videoFile, PATHINFO_FILENAME) . '_frame.jpg';

        FilesController::storeFileOnServer($frame, $imageName, 'posters');
        // Return the path of the saved image
        return env('DATA_URL') . '/posters/' . $imageName;
    }

    public function handleChunk(Request $request)
    {
        Log::write('info', 'handleChunk');

        $receiver = new FileReceiver(
            UploadedFile::fake()->createWithContent('file', $request->getContent()),
            $request,
            ContentRangeUploadHandler::class,
        );

        $save = $receiver->receive();

        if ($save->isFinished()) {
            return response()->json([
                'file' => $save->getFile()->getFilename()
            ]);
        }

        $save->handler();
    }

    public function handleSuccess(Request $request) : JsonResponse
    {
        Log::write('info', 'handleSuccess');
        $path = $request->input('path');
        $name = $request->input('name');

        $file = new UploadedFile(storage_path('app/chunks/' . $path), $name);
        $url =  $file->storeAs('videos', Str::uuid() . '.mp4');

        Log::write('info', $file->getClientOriginalName());

        $fileToUpdate = Files::where('name', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->first();

        if($fileToUpdate) {

            return response()->json([
                'success' => true,
                'entity' => $fileToUpdate->update([
                    'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'url' => $url,
                ])
            ]);
        }

        return response()->json([
            'success' => true,
            'entity' =>  FilesController::storeFileOnDatabase(
                originalName: $file->getClientOriginalName(),
                url: storage_path('app/public/' . $url),
                description: null,
                poster_url: 'thumbnail.example.com',
            )
        ]);
    }

    public function getListe() {
        return response()->json([
            'success' => true,
            'message' => 'Liste des vidéos',
            'rows' => Files::all()->where('id_type', 2),
        ]);
    }

    public function getVideosWithTags(Request $request) : JsonResponse
    {
        $searchName = $request->input('searchName');

        $videos = Files::with('tags')->where('id_type', 2)
            ->when($searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Liste des vidéos avec tags',
            'rows' => $videos,
        ]);
    }

    public function get30RandomVideosWithTags() : JsonResponse
    {
        $videos = Files::with('tags')->where('id_type', 2)->inRandomOrder()->limit(30)->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des 30 vidéos aléatoires avec tags',
            'rows' => $videos,
        ]);
    }

    public function getVideoByTags(Request $request) : JsonResponse
    {
        $tags = $request->input('tags');

        $videos = Files::with('tags')->where('id_type', 2)
            ->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            })
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Liste des vidéos par tags',
            'rows' => $videos,
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
        $video = Files::findOrFail($request->input('id'));

        // Mettre à jour l'image avec les nouvelles données
        $video->update($request->all());

        if ($request->has('tags') && $request->input('tags') !== null) {
            $tags = $request->input('tags');
            $tagsArray = array_map(function($tag) {
                return $tag['id'];
            }, $tags);

            // Supprimer tous les tags actuels de l'image et ajouter les nouveaux tags
            $video->tags()->sync($tagsArray);
        }

        // Retourner une réponse
        return response()->json([
            'success' => true,
            'message' => 'Video updated successfully',
            'video' => $video
        ]);
    }



}

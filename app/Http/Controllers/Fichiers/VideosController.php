<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Jobs\Videos\AssembleFileJob;
use App\Jobs\Videos\ProcessVideoChunk;
use App\Models\Files;
use FFMpeg\FFMpeg;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class VideosController extends Controller
{

    public function upload(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:mp4,avi,flv,mov,wmv',
        ]);

        Log::info('Uploading a video');

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME) . '.mp4';

//        if (FilesController::checkIfFileExists($originalName)) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Cette vidéo existe déjà en base de données',
//            ], 400);
//        }

//        Log::info('Storing the video on the server');
//
//        FilesController::storeFileOnServer($file, $filename, 'videos');
        ProcessVideoChunk::dispatch($request);

        Log::info('Extracting the first frame of the video');

        $posterName = $this->getFirstFrame($file, $originalName);

        Log::info('Storing the video details in the database');

        // Store the video details and the poster URL in the database
        $video = FilesController::storeFileOnDatabase(
            $originalName,
            env('DATA_URL') . '/videos/' . $filename,
            $request->input('description'),
            env('DATA_URL') . '/posters/' . $posterName,
        );

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $tagsArray = json_decode($tags, true);
            foreach ($tagsArray as $tag) {
                $video->tags()->attach($tag['id'], ['file_id' => $video['id'], 'tag_id' => $tag['id']]);
            }
        }


        return response()->json([
            'success' => true,
            'message' => 'Video uploaded and stored successfully',
            'entity' => $video,
        ]);
    }

    public function testUpload(Request $request)
    {
        // Imaginons que vous recevez des informations sur le morceau via une requête POST
        $chunkNumber = $request->input('resumableChunkNumber');
        $totalChunks = $request->input('resumableTotalChunks');
        $identifier = $request->input('resumableIdentifier');
        $filename = $request->input('resumableFilename');
        $chunkFile = $request->file('file'); // Le fichier morceau envoyé

        // Chemin de base pour stocker temporairement les morceaux
        $baseDir = storage_path('app/chunks/' . $identifier);

        // Assurez-vous que le répertoire existe
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0775, true);
        }

        // Déplacer le morceau dans le répertoire temporaire
        $chunkPath = $baseDir . '/' . $chunkNumber;
        $chunkFile->move($baseDir, $chunkNumber);

        // Transférez le morceau sur le serveur FTP
        $disk = Storage::disk('ftp');
        $disk->put('chunks/' . $identifier . '/' . $chunkNumber, file_get_contents($chunkPath));

        // Supprimez le morceau local
        unlink($chunkPath);

        // Vérifiez si tous les morceaux ont été reçus
        $receivedChunks = $disk->files('chunks/' . $identifier);
        if (count($receivedChunks) === (int)$totalChunks) {
            // Tous les morceaux sont là, déplacez l'assemblage en arrière-plan
            AssembleFileJob::dispatch($identifier, $filename, $totalChunks);
        }

        // Si tous les morceaux n'ont pas encore été reçus, retournez une réponse indiquant le progrès
        return response()->json([
            "done" => count($receivedChunks) / $totalChunks,
        ]);
    }


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
        return $imageName;
    }

}

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
        $path = $request->input('path');
        $name = $request->input('name');

        $file = new UploadedFile(storage_path('app/chunks/' . $path), $name);
        $url =  $file->storeAs('videos', Str::uuid() . '.mp4');


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

}

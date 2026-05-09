<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $uploadId = preg_replace('/[^a-zA-Z0-9-]/', '', $request->header('X-Upload-ID', Str::uuid()));
        $tmpPath = storage_path('app/chunks/' . $uploadId . '.part');

        $contentRange = $request->header('Content-Range');
        if (!$contentRange || !preg_match('/bytes (\d+)-(\d+)\/(\d+)/', $contentRange, $m)) {
            return response()->json(['error' => 'Missing Content-Range'], 400);
        }

        $start = (int) $m[1];
        $total = (int) $m[3];
        $chunkData = $request->getContent();

        $chunkDir = storage_path('app/chunks');
        if (!is_dir($chunkDir)) {
            mkdir($chunkDir, 0755, true);
        }

        $handle = fopen($tmpPath, (file_exists($tmpPath) && $start > 0) ? 'r+b' : 'wb');
        if ($handle === false) {
            return response()->json(['error' => 'Failed to open temp file'], 500);
        }
        fseek($handle, $start);
        $written = fwrite($handle, $chunkData);
        fclose($handle);
        if ($written === false) {
            return response()->json(['error' => 'Failed to write chunk'], 500);
        }

        clearstatcache(true, $tmpPath);
        $currentSize = filesize($tmpPath);

        if ($currentSize >= $total) {
            return response()->json(['file' => $uploadId . '.part']);
        }

        return response()->json(['received' => true]);
    }

    public function handleSuccess(Request $request) : JsonResponse
    {
        $path = $request->input('path');
        $name = $request->input('name');

        $file = new UploadedFile(storage_path('app/chunks/' . $path), $name);
        $s3Key = 'videos/' . Str::uuid() . '.mp4';

        $stream = fopen($file->getRealPath(), 'rb');
        Storage::disk('s3')->put($s3Key, $stream);
        fclose($stream);
        @unlink($file->getRealPath());
        $s3Url = Storage::disk('s3')->url($s3Key);

        $fileToUpdate = Files::where('name', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->first();

        if ($fileToUpdate) {
            $fileToUpdate->update([
                'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'url' => $s3Url,
            ]);
            return response()->json([
                'success' => true,
                'entity' => $fileToUpdate->fresh(),
            ]);
        }

        return response()->json([
            'success' => true,
            'entity' => FilesController::storeFileOnDatabase(
                originalName: $file->getClientOriginalName(),
                url: $s3Url,
                description: null,
                poster_url: null,
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

        $videos = Files::with(['tags' => function ($query) {
            $query->orderBy('name');
        }])->where('id_type', 2)
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
        $videos = Files::with(['tags' => function ($query) {
            $query->orderBy('name');
        }])->where('id_type', 2)->inRandomOrder()->limit(30)->get();

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

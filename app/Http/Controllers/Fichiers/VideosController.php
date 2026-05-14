<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\PendingVideoUpload;
use App\Services\BunnyStreamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideosController extends Controller
{

    public function initTusUpload(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $title = pathinfo($name, PATHINFO_FILENAME);

        $bunny = new BunnyStreamService();
        $videoId = $bunny->createVideo($title);
        $credentials = $bunny->generateTusCredentials($videoId);

        PendingVideoUpload::create([
            'video_id' => $videoId,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'videoId' => $videoId,
            'signature' => $credentials['signature'],
            'expires' => $credentials['expires'],
            'libraryId' => $credentials['libraryId'],
        ]);
    }

    public function refreshTusCredentials(Request $request): JsonResponse
    {
        $request->validate(['videoId' => 'required|string']);

        $videoId = $request->input('videoId');

        abort_unless(
            PendingVideoUpload::where('video_id', $videoId)
                ->where('user_id', $request->user()->id)
                ->exists(),
            403
        );

        $bunny = new BunnyStreamService();
        $credentials = $bunny->generateTusCredentials($videoId);
        return response()->json(['success' => true, ...$credentials]);
    }

    public function completeTusUpload(Request $request): JsonResponse
    {
        $request->validate([
            'videoId' => 'required|string',
            'name' => 'required|string',
        ]);

        $videoId = $request->input('videoId');

        abort_unless(
            PendingVideoUpload::where('video_id', $videoId)
                ->where('user_id', $request->user()->id)
                ->exists(),
            403
        );

        $name = $request->input('name');
        $title = pathinfo($name, PATHINFO_FILENAME);

        $bunny = new BunnyStreamService();
        $hlsUrl = $bunny->getHlsUrl($videoId);
        $thumbnailUrl = $bunny->getThumbnailUrl($videoId);

        PendingVideoUpload::where('video_id', $videoId)->delete();

        $fileToUpdate = Files::where('name', $title)->where('id_type', 2)->first();

        if ($fileToUpdate) {
            $fileToUpdate->update([
                'url' => $hlsUrl,
                'poster_url' => $thumbnailUrl,
            ]);
            return response()->json([
                'success' => true,
                'entity' => $fileToUpdate->fresh(),
            ]);
        }

        return response()->json([
            'success' => true,
            'entity' => FilesController::storeFileOnDatabase(
                originalName: $name,
                url: $hlsUrl,
                description: null,
                poster_url: $thumbnailUrl,
                idType: 2,
            )
        ]);
    }

    public function getBunnyStatus(Request $request): JsonResponse
    {
        $request->validate(['videoId' => 'required|string']);

        try {
            $bunny = new BunnyStreamService();
            $status = $bunny->getVideoStatus($request->input('videoId'));
            return response()->json(['success' => true, ...$status]);
        } catch (\Exception) {
            return response()->json(['success' => false, 'status' => -1, 'encodeProgress' => 0]);
        }
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
        ]);

        $video = Files::findOrFail($request->input('id'));

        $video->update($request->all());

        if ($request->has('tags') && $request->input('tags') !== null) {
            $tags = $request->input('tags');
            $tagsArray = array_map(function($tag) {
                return $tag['id'];
            }, $tags);

            $video->tags()->sync($tagsArray);
        }

        return response()->json([
            'success' => true,
            'message' => 'Video updated successfully',
            'video' => $video
        ]);
    }
}

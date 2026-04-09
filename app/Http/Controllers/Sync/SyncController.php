<?php

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function syncImages(): JsonResponse
    {
        return $this->sync('geez-production/images', 'image', 1);
    }

    public function syncVideos(): JsonResponse
    {
        return $this->sync('geez-production/videos', 'video', 2);
    }

    private function videoPosterUrl(string $videoUrl): string
    {
        // Cloudinary génère automatiquement une thumbnail à la seconde 0
        // https://res.cloudinary.com/.../video/upload/so_0/public_id.jpg
        return preg_replace(
            '#/video/upload/#',
            '/video/upload/so_0/',
            preg_replace('/\.[^.]+$/', '.jpg', $videoUrl)
        );
    }

    private function sync(string $folder, string $resourceType, int $idType): JsonResponse
    {
        $created = 0;
        $skipped = 0;
        $nextCursor = null;
        $cloudinaryNames = [];

        do {
            $params = ['max_results' => 500];
            if ($nextCursor) {
                $params['next_cursor'] = $nextCursor;
            }

            $result = cloudinary()->admin()->assetsByAssetFolder($folder, $params);
            $nextCursor = $result['next_cursor'] ?? null;

            Log::debug('[Sync] Cloudinary response', [
                'folder'    => $folder,
                'count'     => count($result['resources']),
                'has_more'  => $nextCursor !== null,
                'resources' => array_map(fn($r) => [
                    'public_id'  => $r['public_id'],
                    'secure_url' => $r['secure_url'],
                    'format'     => $r['format'],
                ], $result['resources']),
            ]);

            foreach ($result['resources'] as $asset) {
                $cloudinaryNames[] = basename($asset['public_id']);
                $name = basename($asset['public_id']);

                if (Files::where('name', $name)->where('id_type', $idType)->exists()) {
                    $skipped++;
                    continue;
                }

                Files::create([
                    'name'        => $name,
                    'url'         => $asset['secure_url'],
                    'id_type'     => $idType,
                    'poster_url'  => $idType === 2 ? $this->videoPosterUrl($asset['secure_url']) : null,
                    'description' => null,
                ]);

                $created++;
            }
        } while ($nextCursor);

        $deleted = Files::where('id_type', $idType)
            ->whereNotIn('name', $cloudinaryNames)
            ->delete();

        Log::debug('[Sync] Patch', ['deleted' => $deleted, 'kept' => $cloudinaryNames]);

        return response()->json([
            'success' => true,
            'created' => $created,
            'skipped' => $skipped,
            'deleted' => $deleted,
        ]);
    }
}

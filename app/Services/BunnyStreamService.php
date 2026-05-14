<?php

namespace App\Services;

use GuzzleHttp\Client;

class BunnyStreamService
{
    private string $apiKey;
    private string $libraryId;
    private string $cdnHostname;
    private string $baseUrl = 'https://video.bunnycdn.com';
    private Client $client;

    public function __construct()
    {
        $this->apiKey = config('services.bunny.api_key');
        $this->libraryId = config('services.bunny.library_id');
        $this->cdnHostname = config('services.bunny.cdn_hostname');
        $this->client = new Client();
    }

    public function createVideo(string $title): string
    {
        $response = $this->client->post("{$this->baseUrl}/library/{$this->libraryId}/videos", [
            'headers' => [
                'AccessKey' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => ['title' => $title],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        if (empty($data['guid'])) {
            throw new \RuntimeException('Bunny API did not return a video guid');
        }
        return $data['guid'];
    }

    public function uploadVideo(string $videoId, string $filePath): void
    {
        $this->client->put("{$this->baseUrl}/library/{$this->libraryId}/videos/{$videoId}", [
            'headers' => [
                'AccessKey' => $this->apiKey,
                'Content-Type' => 'application/octet-stream',
            ],
            'body' => fopen($filePath, 'rb'),
            'timeout' => 0,
        ]);
    }

    public function getHlsUrl(string $videoId): string
    {
        return "https://{$this->cdnHostname}/{$videoId}/playlist.m3u8";
    }

    public function getThumbnailUrl(string $videoId): string
    {
        return "https://{$this->cdnHostname}/{$videoId}/thumbnail.jpg";
    }

    public function getVideoStatus(string $videoId): array
    {
        $response = $this->client->get("{$this->baseUrl}/library/{$this->libraryId}/videos/{$videoId}", [
            'headers' => [
                'AccessKey' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return [
            'status' => $data['status'] ?? -1,
            'encodeProgress' => $data['encodeProgress'] ?? 0,
        ];
    }

    public function generateTusCredentials(string $videoId): array
    {
        $expires = time() + 3600;
        $signature = hash('sha256', $this->libraryId . $this->apiKey . $expires . $videoId);

        return [
            'signature' => $signature,
            'expires' => $expires,
            'libraryId' => $this->libraryId,
        ];
    }
}

<?php

namespace App\Jobs\Videos;

use FFMpeg\Coordinate\TimeCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $videoPath;

    /**
     * Create a new job instance.
     */
    public function __construct($videoPath)
    {
        $this->videoPath = $videoPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $thumbnailPath = 'thumbnails/' . pathinfo($this->videoPath, PATHINFO_FILENAME) . '.jpg';

        // Commande FFmpeg pour générer la vignette
        $ffmpegCommand = "ffmpeg -i " . storage_path('app/public/' . $this->videoPath) . " -ss 00:00:01.000 -vframes 1 " . storage_path('app/public/' . $thumbnailPath);

        exec($ffmpegCommand, $output, $return_var);

        if ($return_var === 0) {
            Log::info('Thumbnail created: ' . $thumbnailPath);
            // Ici, vous pouvez également mettre à jour la base de données si nécessaire
        } else {
            Log::error('Failed to create thumbnail for ' . $this->videoPath);
        }
    }
}

<?php

namespace App\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class AssembleFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $identifier;
    protected $filename;
    protected $totalChunks;

    public function __construct($identifier, $filename, $totalChunks)
    {
        $this->identifier = $identifier;
        $this->filename = $filename;
        $this->totalChunks = $totalChunks;
    }

    public function handle()
    {
        $disk = Storage::disk('ftp');
        $baseDir = storage_path('app/chunks/' . $this->identifier);
        $finalPath = 'uploads/' . $this->filename;

        $fileHandle = fopen($baseDir . '/' . $this->filename, 'wb');

        for ($i = 1; $i <= $this->totalChunks; $i++) {
            $chunkData = $disk->get('chunks/' . $this->identifier . '/' . $i);
            fwrite($fileHandle, $chunkData);
        }

        fclose($fileHandle);

        $disk->put($finalPath, file_get_contents($baseDir . '/' . $this->filename));
        $disk->deleteDirectory('chunks/' . $this->identifier);
        unlink($baseDir . '/' . $this->filename);
    }
}

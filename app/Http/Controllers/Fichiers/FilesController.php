<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use http\Env;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public static function checkIfFileExists($originalName) : bool
    {
        if (Files::class::where('name', pathinfo($originalName, PATHINFO_FILENAME))->exists()) {
            return false;
        } else {
            return true;
        }
    }

    public static function storeFileOnServer($file, $filename, $filetype) : string
    {
        switch ($filetype) {
            case 'images':
                Log::info('Saving the image file locally', ['filename' => $filename]);
                Storage::disk('ftp')->put('images/'.$filename, (string) $file, 'public');
                return  env('DATA_URL') . '/images/' . $filename;
            case 'posters':
                Storage::disk('ftp')->put('posters/'.$filename . '.webp', (string) $file, 'public');
                return env('DATA_URL') . '/posters/' . $filename. '.webp';
            case 'videos':
                Log::info('Saving the video file locally', ['filename' => $filename]);
                // Ici, on suppose que $file est déjà sous forme de string/binaire. Sinon, adaptez selon besoin.
                Storage::disk('ftp')->put('videos/'.$filename, (string) $file, 'public');
                return env('DATA_URL') . '/videos/' . $filename;
        }
        return '';
    }

    public static function storeFileOnDatabase($originalName, $url, ?string $description, ?string $poster_url) : Files
    {
        return Files::class::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'description' => $description,
            'url' => $url,
            'id_type' => $poster_url ? 2 : 1,
            'poster_url' => $poster_url ?? null,
        ]);
    }

    public static function sortedFilesListe($files) : Collection
    {
        return $files->sortBy(function ($photo) {
            return $photo->tags->first()->name ?? null;
        });
    }
}

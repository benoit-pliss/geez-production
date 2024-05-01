<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Models\Files;
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

    public static function storeFileOnServer($file, $filename, $filetype) : void
    {
        switch ($filetype) {
            case 'images':
                Log::info('Saving the image file locally', ['filename' => $filename]);
                Storage::disk('ftp')->put('images/'.$filename, (string) $file, 'public');
                break;
            case 'posters':
                $imageName = storage_path('app/public/posters/' . $filename);

                try {
                    $file->save($imageName);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return;
                }

                // Store the image file using FTP
                $imageFile = file_get_contents($imageName);
                Storage::disk('ftp')->put('posters/'.$filename, $imageFile, 'public');

                // Delete the local image file
                unlink($imageName);
                break;
            case 'videos':
                Log::info('Saving the video file locally', ['filename' => $filename]);
                // Ici, on suppose que $file est déjà sous forme de string/binaire. Sinon, adaptez selon besoin.
                Storage::disk('ftp')->put('videos/'.$filename, (string) $file, 'public');
                break;

        }
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
}
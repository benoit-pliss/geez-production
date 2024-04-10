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
                $file->storeAs('videos', $filename, 'ftp');
                break;
        }
    }

    public static function storeFileOnDatabase($originalName, $url, $description, ?string $poster_url) : Files
    {
        return Files::class::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'description' => $description,
            'url' => $url,
            'poster_url' => $poster_url,
        ]);
    }
}

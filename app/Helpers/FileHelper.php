<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function upload(UploadedFile $file, string $folder = 'covers'): array
    {
        $path = $file->store($folder, 'public');

        return [
            'path' => $path,
            'alt_text' => $file->getClientOriginalName(),
            'size' => $file->getSize()
        ];
    }

    public static function delete(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
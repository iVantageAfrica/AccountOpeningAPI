<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadHelper
{
    public static function uploadFile(UploadedFile $file): ?string
    {
        $storedPath = $file->store('documents', 'public');
        return $storedPath ? self::getPublicUrl($storedPath) : null;
    }

    public static function delete(string $url): void
    {
        $parsedPath = parse_url($url, PHP_URL_PATH);
        $cleanPath = ltrim(str_replace('/storage/', '', $parsedPath), '/');
        Storage::disk('public')->delete($cleanPath);
    }

    public static function getPublicUrl(string $path): ?string
    {
        if (str_starts_with($path, 'http')) {
            return $path;
        }
        return rtrim(config('app.url'), '/') . Storage::url($path);
    }

    public static function buildDocumentPath(?string $filename): ?string
    {
        if (!$filename) {
            return null;
        }
        if (str_starts_with($filename, 'http')) {
            return $filename;
        }
        return self::getPublicUrl("documents/{$filename}");
    }

}

<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

abstract class BaseService
{
    /**
     * Upload a file to the specified disk and path.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string|false
     */
    protected function uploadFile(UploadedFile $file, string $path, string $disk = 'public'): string|false
    {
        return $file->store($path, $disk);
    }

    /**
     * Delete a file from storage.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    protected function deleteFile(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }
}

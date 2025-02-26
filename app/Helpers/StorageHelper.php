<?php

namespace App\Helpers;

class StorageHelper
{
    /**
     * Get the actual path of the file in storage.
     *
     * @param string $filePath
     * @return string|null
     */
    public static function getStoragePath($filePath)
    {
        $relativePath = str_replace('storage/', '', $filePath);
        $fullPath = storage_path("app/public/{$relativePath}");

        return file_exists($fullPath) ? $fullPath : null;
    }
}

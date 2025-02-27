<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

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

    /**
     * Upload image to storage
     * @author TranVanNhat <TranVanNhat7624@gmail.com>
     * @param $request
     * @param $fieldName
     * @param $folderName
     * @return array|null
     */
    public function storageFileUpload($file, $folderName)
    {
        if ($file) {
            $path = $file->store($folderName);
            $dataUpload = [
                'name' => $file->getClientOriginalName(),
                'path' => "/storage/{$path}"
            ];

            return $dataUpload;
        }
        return null;
    }
}

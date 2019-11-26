<?php


namespace App\Services;

use App\Constants\StorageConstants;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class UploadService
{
    /**
     * Method for uploading a private image
     *
     * @param UploadedFile $file
     *
     * @return File
     */
    public function savePrivateImage(UploadedFile $file): File
    {
        $basename = Str::random();
        $original = $basename . '.' . $file->getClientOriginalExtension();

        $file = $file->move(storage_path(StorageConstants::IMAGES), $original);

        return $file;
    }
}

<?php


namespace App\Services;

use App\Constants\StorageConstants;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadService
{
    /**
     * Method for uploading a private image
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    public function savePrivateImage(UploadedFile $file): string
    {
        $basename = Str::random();
        $original = $basename . '.' . $file->getClientOriginalExtension();

        $file = $file->move(storage_path(StorageConstants::IMAGES), $original);

        return $file->getRealPath();
    }
}

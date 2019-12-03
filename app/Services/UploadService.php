<?php


namespace App\Services;

use App\Constants\StorageConstants;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class UploadService
{
    public function savePrivateContent(UploadedFile $file, string $path): File
    {
        $basename = Str::random();
        $original = $basename . '.' . $file->getClientOriginalExtension();

        $file = $file->move(storage_path($path), $original);

        return $file;
    }
}

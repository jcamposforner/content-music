<?php

namespace App\Http\Controllers;

use App\Constants\StorageConstants;
use App\Events\CropImageEvent;
use App\Events\ResizeVideoEvent;
use App\Http\Requests\UploadProfilePictureRequest;
use App\Http\Requests\UploadVideoRequest;
use App\Services\UploadService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseFactoryInterface;

class UploadController extends Controller
{
    /**
     * Upload profile picture for the current logged user
     *
     * @param UploadProfilePictureRequest $request
     * @param UploadService $uploadService
     *
     * @return ResponseFactoryInterface
     */
    public function uploadProfilePicture(UploadProfilePictureRequest $request, UploadService $uploadService)
    {
        if (!is_dir(storage_path(StorageConstants::IMAGES))) {
            mkdir(storage_path(StorageConstants::IMAGES), 0777);
        }

        $images = Collection::wrap($request->file('image'));

        $images->each(function (\Illuminate\Http\UploadedFile $image) use ($request, $uploadService) {
            $original = $uploadService->savePrivateContent($image, StorageConstants::IMAGES);
            event(new CropImageEvent($original->getRealPath()));
            $request->user()->image()->delete();
            $request->user()->image()->create(['uri' => $original->getBasename(), 'path' => $original->getRealPath()]);
        });

        $user = $request->user()->with('image')->get();
        return response()->json([
            'status'  => 201,
            'data'    => $user,
            'message' => 'Successfully upload!'
        ], 201);
    }

    /**
     * Upload video
     *
     * @param $request
     * @param UploadService $uploadService
     *
     * @return ResponseFactoryInterface
     */
    public function uploadVideoContent(UploadVideoRequest $request, UploadService $uploadService)
    {
        $videos = Collection::wrap($request->file('video'));
        $videos->each(function (\Illuminate\Http\UploadedFile $video) use ($request, $uploadService) {
            $original = $uploadService->savePrivateContent($video, StorageConstants::VIDEOS);
            event(new ResizeVideoEvent($original->getRealPath()));
        });

        return response()->json([
            'status'  => 201,
            'data'    => $videos->last()->getBaseName(),
            'message' => 'Successfully upload!'
        ], 201);
    }
}

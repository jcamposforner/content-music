<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProfilePictureRequest;
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
        if (!is_dir(public_path('/images'))) {
            mkdir(storage_path('/images'), 0777);
        }

        $images = Collection::wrap($request->file('image'));

        $images->each(function (\Illuminate\Http\UploadedFile $image) use ($request, $uploadService) {
            $original = $uploadService->savePrivateImage($image);
            $request->user()->image()->delete();
            $request->user()->image()->create(['uri' => '/images/' . $original]);
        });

        $user = $request->user()->with('image')->get();
        return response()->json([
            'status'  => 201,
            'data'    => $user,
            'message' => 'Successfully upload!'
        ], 201);
    }
}

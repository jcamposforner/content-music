<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProfilePictureRequest;
use App\Image;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload profile picture for the current logged user
     *
     * @param UploadProfilePictureRequest $request
     *
     * @return [json] user object
     */
    public function uploadProfilePicture(UploadProfilePictureRequest $request)
    {
        if (!is_dir(public_path('/images'))) {
            mkdir(public_path('/images'), 0777);
        }

        $images = Collection::wrap($request->file('image'));

        $images->each(function ($image) use ($request) {
            $basename = Str::random();
            $original = $basename . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('/images'), $original);

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

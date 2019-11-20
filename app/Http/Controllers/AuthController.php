<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\RegisterMail;
use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Webpatser\Uuid\Uuid;

class AuthController extends Controller
{
    /**
     * Register
     *
     * @param RegisterRequest $request
     * @param User $user
     *
     * @return Response
     */
    public function register(RegisterRequest $request, User $user)
    {
        try {
            $user->email    = $request->email;
            $user->name     = $request->name;
            $user->password = bcrypt($request->password);

            $uuid = Uuid::generate()->string;
            Mail::to($request->email)->send(new RegisterMail($user, $uuid));
            $user->save();
            Redis::set($uuid, $user->id, 'EX', 3600);

            return \response([
                'status' => 200,
                'data'   => $user
            ], 200);
        } catch (Exception $e) {
            return \response([
                'status' => 500,
                'data'   => "An error has ocurred"
            ], 500);
        }
    }

    /**
     * Login
     *
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::where(['email' => $request->email])->whereNotNull('email_verified_at')->first();

        if (!$user) {
            return \response([
                'status' => 403,
                'data'   => "Unauthorized"
            ], 403);
        }

        if (Hash::check($request->password, $user->password)) {
            $request->session()->put('user', $user);
            return \response([
                'status' => 200,
                'data'   => $user
            ], 200);
        }

        $request->session()->put('login', null);
        return \response([
            'status' => 403,
            'data'   => "Unauthorized"
        ], 403);
    }

    /**
     * Verify UUID stored on redis for 1 hour
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function verifyEmail(string $uuid)
    {
        $userId = Redis::get($uuid);
        if (!$userId) {
            return \response([
                'status' => 404,
                'data'   => "Not Found"
            ], 404);
        }
        Redis::del($uuid);

        $user = User::find($userId);
        $user->email_verified_at = new \Datetime();
        $user->save();

        return \response([
            'status' => 200,
            'data'   => $user
        ], 200);
    }
}

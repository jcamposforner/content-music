<?php

namespace App\Http\Controllers;

use App\Events\NewUserHasRegisteredEvent;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Request;
use Webpatser\Uuid\Uuid;

class AuthController extends Controller
{
    /**
     * @param string $uuid
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
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
        $user->active = true;
        $user->save();

        return \response([
            'status' => 200,
            'data'   => $user
        ], 200);
    }

    /**
     * @param RegisterRequest $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function signup(RegisterRequest $request, User $user)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        $uuid = Uuid::generate()->string;
        Redis::set($uuid, $user->id, 'EX', 3600);
        event(new NewUserHasRegisteredEvent($user, $uuid));

        return response()->json([
            'status'  => 201,
            'data'    => '',
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (
            !Auth::attempt([
                'email'    => $request->email,
                'password' => $request->password,
                'active'   => true
            ])
        ) {
            return response()->json([
                'status'  => 401,
                'data'    => '',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'status' => 200,
            'data' => [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ],
            'message' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status'  => 200,
            'data'    => '',
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data' => $request->user(),
            'message' => ''
        ]);
    }
}

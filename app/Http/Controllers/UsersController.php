<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    public function signIn(Request $request)
    {
        $profile = Socialite::driver('github')
            ->userFromToken($request->input('token'));

        $user = User::findByGithubId($profile->getId());

        $code = 200;

        if (!$user->exists()) {
            $user = User::create([
                'name' => $profile->getName(),
                'email' => $profile->getEmail(),
                'provider' => 'github',
                'provider_id' => $profile->getId(),
            ]);

            $code = 201;
        }

        $user->api_token = JWTAuth::fromUser($user);

        return response()->json($user, $code);
    }
}

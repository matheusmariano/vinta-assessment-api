<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class UsersController extends Controller
{
    public function signIn(Request $request)
    {
        $profile = Socialite::driver('github')
            ->userFromToken($request->input('token'));

        $user = User::findByGithubId($profile->getId());

        if ($user->exists()) {
            return response()->json($user, 200);
        }

        $user = User::create([
            'name' => $profile->getName(),
            'email' => $profile->getEmail(),
            'provider' => 'github',
            'provider_id' => $profile->getId(),
        ]);

        return response()->json($user, 201);
    }
}

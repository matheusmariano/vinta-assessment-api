<?php

namespace Tests\Feature\Controllers;

use Mockery;
use App\User;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Provider;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersControllerTest extends TestCase
{
    public function testSignUp()
    {
        $user = factory(User::class)->make();
        $token = str_random();

        $profile = Mockery::mock(SocialiteUser::class);
        $profile
            ->shouldReceive('getId')
            ->andReturn($user->provider_id)
            ->shouldReceive('getName')
            ->andReturn($user->name)
            ->shouldReceive('getEmail')
            ->andReturn($user->email);

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('userFromToken')
            ->with($token)
            ->andReturn($profile);

        Socialite::shouldReceive('driver')
            ->with('github')
            ->andReturn($provider);

        $response = $this->json('POST', 'users', compact('token'));

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'provider' => 'github',
            'provider_id' => $user->provider_id,
        ]);
    }

    public function testSignIn()
    {
        $user = factory(User::class)->create();
        $token = str_random();

        $profile = Mockery::mock(SocialiteUser::class);
        $profile
            ->shouldReceive('getId')
            ->andReturn($user->provider_id)
            ->shouldReceive('getName')
            ->andReturn($user->name)
            ->shouldReceive('getEmail')
            ->andReturn($user->email);

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('userFromToken')
            ->with($token)
            ->andReturn($profile);

        Socialite::shouldReceive('driver')
            ->with('github')
            ->andReturn($provider);

        $response = $this->json('POST', 'users', compact('token'));

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Models;

use App\User;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testSanity()
    {
        $this->assertTrue($this->user->exists());
    }

    public function testEmailUniqueness()
    {
        $this->expectException(QueryException::class);

        factory(User::class)->create([
            'email' => $this->user->email,
        ]);
    }

    public function testProviderUniqueness()
    {
        factory(User::class)->create([
            'provider' => $this->user->provider,
        ]);

        $this->expectException(QueryException::class);

        factory(User::class)->create([
            'password' => null,
            'provider' => $this->user->provider,
            'provider_id' => $this->user->provider_id,
        ]);
    }

    public function testFindByGithubId()
    {
        $user = User::findByGithubId($this->user->provider_id);

        $this->assertEquals($user->id, $this->user->id);
    }
}

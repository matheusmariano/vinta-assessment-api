<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repository;
use Illuminate\Database\QueryException;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = factory(Repository::class)->create();
    }

    public function testSanity()
    {
        $this->assertTrue($this->repository->exists());
    }

    public function testUniqueness()
    {
        $repository = [
            'name' => 'another/repository',
            'user_id' => $this->repository->user_id,
        ];

        factory(Repository::class)->create($repository);

        $this->assertDatabaseHas('repositories', $repository);

        $this->expectException(QueryException::class);

        factory(Repository::class)->create($repository);
    }
}

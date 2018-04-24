<?php

namespace Tests\Feature\Models;

use App\Commit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommitTest extends TestCase
{
    use RefreshDatabase;

    protected $commit;

    public function setUp()
    {
        parent::setUp();

        $this->commit = factory(Commit::class)->create();
    }

    public function testSanity()
    {
        $this->assertTrue($this->commit->exists());
    }
}

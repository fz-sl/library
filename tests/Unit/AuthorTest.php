<?php

namespace Tests\Unit;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function only_name_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'john Doe'
        ]);

        $this->assertCount(1 ,Author::all());

    }
}

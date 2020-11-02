<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/author',[
            'name' => 'Author Name',
            'dob' => '9/9/1999',
        ])->assertOk();

        $this->assertCount(1 , Author::all());
        $this->assertInstanceOf(Carbon::class, Author::first()->dob);
    }
}

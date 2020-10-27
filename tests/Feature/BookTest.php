<?php

namespace Tests\Feature;


use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'title',
            'author' => 'faraz',
        ]);

        $response->assertOk();
        $this::assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'faraz',
        ]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Book title',
            'author' => '',
        ]);
        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Book title',
            'author' => 'faraz',
        ]);
        $this->assertCount(1, Book::all());

        $this->patch('books/' . Book::first()->id, [
            'title' => 'New title',
            'author' => 'New author'
        ])->assertOk();

        $this->assertEquals('New title', Book::find(1)->title);
        $this->assertEquals('New author', Book::find(1)->author);

    }
}

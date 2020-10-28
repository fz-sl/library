<?php

namespace Tests\Feature;


use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('books/', [
            'title' => 'title',
            'author' => 'faraz',
        ]);


        $this->assertCount(1, Book::all());
        $response->assertRedirect('books/'. Book::first()->id);
    }

    /** @test */
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('books/', [
            'title' => '',
            'author' => 'faraz',
        ]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('books/', [
            'title' => 'Book title',
            'author' => '',
        ]);
        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('books/', [
            'title' => 'Book title',
            'author' => 'faraz',
        ]);
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->patch($book->path(), [
            'title' => 'New title',
            'author' => 'New author'
        ]);
        $this->assertEquals('New title', $book->fresh()->title);
        $this->assertEquals('New author', $book->fresh()->author);

        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('books/',[
            'title' => 'title',
            'author' => 'faraz',
        ]);
        $book = Book::first();
        $this->assertEquals(1 , Book::all()->count());

        $response = $this->delete('books/' . $book->id);

        $this->assertEquals(0 , Book::all()->count());

        $response->assertRedirect('books/');
    }


}

<?php

namespace Tests\Feature;


use App\Author;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('books/', $this->data());

        $this->assertCount(1, Book::all());
        $response->assertRedirect('books/' . Book::first()->id);
    }

    /** @test */
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('books/', array_merge($this->data(),['title'=>'']));
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('books/', array_merge($this->data(),['author_id'=>'']));
        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('books/', $this->data());
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->patch($book->path(), [
            'title' => 'New title',
            'author_id' => 'New author'
        ]);
        $this->assertEquals('New title', $book->fresh()->title);
        $this->assertEquals(2, $book->fresh()->author_id);

        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('books/', $this->data());
        $book = Book::first();
        $this->assertEquals(1, Book::all()->count());

        $response = $this->delete('books/' . $book->id);

        $this->assertEquals(0, Book::all()->count());

        $response->assertRedirect('books/');
    }

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('books/', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }



    /**
     * @return array
     */
    private function data(): array
    {
        return [
            'title' => 'title',
            'author_id' => 'faraz',
        ];
    }


}

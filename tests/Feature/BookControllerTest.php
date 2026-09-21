<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_books(): void
    {
        Book::factory(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'author', 'genres'],
            ],
        ]);
    }

    public function test_it_can_create_a_book(): void
    {
        $author = Author::factory()->create();

        $response = $this->postJson('/api/books', [
            'title' => 'Cien años de soledad',
            'author_id' => $author->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['title' => 'Cien años de soledad']);
    }

    public function test_it_can_show_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $book->id);
    }

    public function test_it_can_update_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->patchJson("/api/books/{$book->id}", ['title' => 'Nuevo título']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Nuevo título']);
    }

    public function test_it_can_delete_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_authors(): void
    {
        Author::factory(3)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name'],
            ],
        ]);
    }

    public function test_it_can_create_an_author(): void
    {
        $data = ['name' => 'Gabriel García Márquez'];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', ['name' => 'Gabriel García Márquez']);
    }

    public function test_it_can_update_an_author(): void
    {
        $author = Author::factory()->create(['name' => 'Gabriel García Márquez']);

        $response = $this->patchJson("/api/authors/{$author->id}", ['name' => 'Nombre Actualizado']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', ['id' => $author->id, 'name' => 'Nombre Actualizado']);
    }

    public function test_it_can_show_an_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $author->id);
    }

    public function test_it_can_delete_an_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
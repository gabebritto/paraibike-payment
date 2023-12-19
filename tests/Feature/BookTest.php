<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_books()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get('/api/books');
        Book::factory(10)->create();

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'publication_date',
                        'available_qty',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_for_store_book()
    {
        $this->actingAs(User::factory()->create());
        $faker = Factory::create();

        $payload = [
            'name' => $faker->name(),
            'publication_date' => $faker->date(),
            'available_qty' => $faker->randomNumber()
        ];

        $this->json('post', 'api/books', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' =>
                    [
                        'id',
                        'name',
                        'publication_date',
                        'available_qty',
                        'created_at',
                        'updated_at'
                    ]
            ])
            ->assertJson([
                'message' => 'Book created successfully'
            ]);
    }

    public function test_for_find_book_by_id()
    {
        $this->actingAs(User::factory()->create());
        $book = Book::factory()->create();

        $this->get('api/books/' . $book->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'publication_date',
                    'available_qty',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                    'name' => $book->name
                ]
            ]);
    }

    public function test_for_book_not_found()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get('api/books/99999999999');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message'
            ])
            ->assertJson([
                'message' => 'Resource not found'
            ]);
    }

    public function test_for_update_book()
    {
        $this->actingAs(User::factory()->create());
        $book = Book::factory()->create();

        $payload = [
            'name' => 'Updated',
            'publication_date' => Carbon::now()->toString(),
            'available_qty' => $book->available_qty - 1,
        ];

        $this->json('put', 'api/books/' . $book->id, $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data'
            ])
            ->assertJson([
                'message' => 'Book updated successfully',
                'data' => [
                    'name' => $payload['name'],
                    'publication_date' => $payload['publication_date'],
                    'available_qty' => $payload['available_qty']
                ]
            ]);
    }

    public function test_for_delete_book()
    {
        $this->actingAs(User::factory()->create());
        $book = Book::factory()->create();

        $this->json('delete', 'api/books/' . $book->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ])->assertJson([
                'message' => 'Book deleted successfully.'
            ]);
    }

    public function test_for_store_book_required_fields()
    {
        $this->actingAs(User::factory()->create());
        $this->json('post', '/api/books')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'publication_date',
                'available_qty'
            ]);
    }

    public function test_for_update_book_required_fields()
    {
        $this->actingAs(User::factory()->create());
        $book = Book::factory()->create();

        $this->json('put', 'api/books/' . $book->id)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'publication_date',
                'available_qty'
            ]);
    }

    public function test_for_update_book_not_found()
    {
        $this->actingAs(User::factory()->create());
        $this->json('put', 'api/books/' . 999999)
            ->assertStatus(404)
            ->assertJsonStructure([
                'message'
            ])
            ->assertJson([
                'message' => 'Resource not found'
            ]);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Book;

use Tests\CommonData;

/**
 * Class BookTest
 *
 * This is more of a "feature" test in that it calls the API server and parses some of its results; hence it is
 * testing both the controller(s) and the resource controllers (a little bit - not completely).
 */
class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->seed();

        $response = $this->getJson('/api/v1/book');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');

        $data = $response->json();

        foreach ($data as $index => $value) {
            $this->assertTrue(CommonData::contains($value),
                sprintf('The record for the book "%s" (%d) is not valid.', $value['title'], $value['id']));
        }
    }

    /**
     * Fetch one of the records and make sure we get the right one back.
     */
    public function testGetIdOne()
    {
        $this->seed();

        $response = $this->getJson('/api/v1/book/1');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');

        $data = $response->json();

        $this->assertIsArray($data, 'Response should be an array.');

        // Get 'The Hunger' - currently hard coded as book 0.
        // @todo We probably should filter for this.
        $book = CommonData::$books[0];
        $this->assertEquals('The Hunger', $book['title']);

        $this->assertTrue(CommonData::contains($data, [$book]), 'The record (1) should be the book, "The Hunger".');
    }

    public function testUpdate() {
        $this->seed();

        // Perform the updated.
        $id = 1;

        $data = [
            'title' => 'Updated title',
            'author' => 'Updated author',
            'format' => 'Updated format',
            '_method' => 'PUT',
        ];

        $currentBook = Book::find($id);

        $this->assertNotNull($currentBook, "The book with ID '$id' must exist.");
        $this->assertNotEquals('Updated title', $currentBook->title,'The title should not already have been updated.');

        $didUpdate = $this->postJson("api/v1/book/$id", $data);

        $response = $didUpdate->json();

        // Verify the update response

        // Massage the data...
        foreach (['author', 'title', 'format'] as $check) {
            $this->assertArrayHasKey($check, $response);
            $this->assertNotNull($response[$check]);
        }

        $data['id'] = $id;

        // Build a subset to check.
        $check = [
            'id' => $id,
            'author' => $response['author'],
            'title' => $response['title'],
            'format' => $response['format'],
            // We don't really get this but this is better than deleting from $data.
            '_method' => 'PUT',
        ];

        $this->assertEquals($data, $check);

        // Retrieve the item from the API again.
        $response = $this->getJson("/api/v1/book/$id");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');

        $data = $response->json();

        $this->assertIsArray($data, 'Response should be an array.');

        // Get 'The Hunger' - currently hard coded as book 0.
        // @todo We probably should filter for this.
        $this->assertTrue(CommonData::contains($data, [$check]), 'The record (1) should contain the updated data.');
    }

    public function testDelete()
    {
        $this->seed();

        // Perform the updated.
        $id = 1;

        $currentBook = Book::find($id);
        $this->assertNotNull($currentBook, "The book with ID '$id' must exist.");

        $response = $this->deleteJson("api/v1/book/$id");
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');

        // Deleting TWICE should get a 404.
        $response = $this->deleteJson("api/v1/book/$id");
        $response->assertStatus(404);
        $response->assertHeader('content-type', 'application/json');

        // Retrieving the book should get a 404.
        $response = $this->getJson("api/v1/book/$id");
        $response->assertStatus(404);
        $response->assertHeader('content-type', 'application/json');

        $currentBook = Book::find($id);
        $this->assertNull($currentBook, "Book $id must not exist.");
    }
}

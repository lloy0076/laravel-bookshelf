<?php

namespace Tests\Unit;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testBookDatabase()
    {
        $this->seed();

        // Perform some basic input validation.
        $this->assertCount(3, CommonData::$books);

        // It's definitely wrong if the count is out.
        $this->assertDatabaseCount('books', 3);

        // Only then check item by item.
        foreach (CommonData::$books as $index => $value) {
            $this->assertDatabaseHas('books', $value);
        }

        $this->assertTrue(true);
    }
}

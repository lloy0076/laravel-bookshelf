<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = new Collection([
            [
                'id' => 1,
                'title' => 'The Hunger',
                'author' => 'Whitley Strieber',
                'format' => 'paperback',
            ],
            [
                'id' => 2,
                'title' => 'Kanban - Just-In-Time At Toyota',
                'author' => 'Japan Managment Association',
                'format' => 'hardcover',
            ],
            [
                'id' => 3,
                'title' => 'A Pocket Style Manual',
                'author' => 'Diana Hacker and Nancy Sommers',
            ]
        ]);

        $books->each(function ($book) {
            $didCreate = \App\Book::create($book);
            if (!$didCreate) {
                throw new \Exception(sprintf('Unable to create book, "%s".',$book['title']));
            }
        });
    }
}

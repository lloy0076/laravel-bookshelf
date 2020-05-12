<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

use Tests\CommonData;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = new Collection(CommonData::$books);

        $books->each(function ($book) {
            $didCreate = \App\Book::create($book);
            if (!$didCreate) {
                throw new \Exception(sprintf('Unable to create book, "%s".',$book['title']));
            }
        });

//        $this->random();
    }

    /**
     * Add a certain number of random entries.
     *
     * @param int $num
     */
    public function random($num = 25) {
        factory(\App\Book::class, $num)->create();
    }
}

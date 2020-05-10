<?php

namespace Tests;

use Illuminate\Support\Facades\Log;

class CommonData
{
    public static $books = [
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
    ];

    /**
     * This is not all that elegant HOWEVER it does work...
     *
     * @todo This is some sort of shallow or deep equal, I am sure of it.
     *
     * @param array $what
     * @return bool
     */
    public static function contains($what = [], $compareTo = null)
    {
        $them = $compareTo ? $compareTo : static::$books;

        foreach ($them as $index => $book) {
            // Check fields which MUST be present
            if (isset($what['id'], $what['title'], $what['author'])
                && $book['id'] === $what['id']
                && $book['title'] === $what['title']
                && $book['author'] === $what['author']) {

                // If there should be a format, make sure it is present AND it is the same.
                if (isset($book['format'])) {
                    if (isset($what['format']) && $book['format'] === $what['format']) {
                        return true;
                    } else {
                        return false;
                    }
                }

                // However, if we get an unexpected format, that's an error too.
                if (isset($what['format'])) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }
}

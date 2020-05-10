<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->company,
        'author' => $faker->name,
        // 1/2 paperbock, 1/3 hard cover, rest unknown.
        'format' => rand(0, 1) == 1 ? 'paperback' : (rand(0, 3) > 0 ? 'hardcover': null),
    ];
});

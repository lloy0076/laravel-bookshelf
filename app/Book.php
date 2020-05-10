<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['title', 'author', 'format'];

    use SoftDeletes;
}

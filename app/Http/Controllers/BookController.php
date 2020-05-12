<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $books = Book::orderBy('id')->get();
        $collection = new BookCollection($books);

        return response()->json($collection, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'format' => 'nullable|string|max:255',
        ]);

        $values = $valid->validate();

        $saved = Book::create([
            'title' => $values['title'],
            'author' => $values['author'],
            'format' => $values['format'] ?? null,
        ]);

        if (!$saved) {
            throw new \Exception('Attempt to create new book failed.');
        }

        $resource = new BookResource($saved);

        return response()->json($resource, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function show(Book $book)
    {
        $resource = new BookResource($book);
        return response()->json($resource, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Book $book
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, Book $book)
    {
        $valid = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'format' => 'nullable|string|max:255',
        ]);

        $values = $valid->validate();

        $didSave = $book->update($values);

        if (!$didSave) {
            throw new \Exception("Failed to update book " . $book->id . ".");
        }

        $resource = new BookResource($book);

        return response()->json($resource, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        $didDelete = $book->delete();

        if (!$didDelete) {
            throw new \Exception('Failed to delete book ' . $book->id . '.');
        }

        return response()->json('ok', 200);
    }
}

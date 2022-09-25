<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookQueryRequest;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index(BookQueryRequest $request)
    {
        extract($request->all());

        $books = Book::select('id', 'title', 'author', 'genre_id')
            ->when($title, function ($query, $title) {
                $query->where('title', 'ILIKE', "%{$title}%");
            })
            ->when($author, function ($query, $author) {
                $query->where('author', 'ILIKE', "%{$author}%");
            })
            ->when($genre_id, function ($query, $genre_id) {
                $query->where('genre_id', '=', $genre_id);
            })
            ->with('genre')
            ->orderBy('id')
            ->get();
        return \response(BookResource::collection($books), Response::HTTP_OK);
    }

    public function show($id)
    {
        try {
            $book = Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return \response([
                'message' => 'Book Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new BookResource($book->load('genre'));
    }

    public function store(BookRequest $request)
    {
        $book = Book::create($request->all());

        return \response( new BookResource($book->load('genre')), Response::HTTP_CREATED);

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $title = (null !== $request->query('title')) ? $request->query('title') : null;
        $author = (null !== $request->query('author')) ? $request->query('author') : null;
        $genre_id = (null !== $request->query('genre_id')) && is_integer($request->query('genre_id'))  ? $request->query('genre_id') : null;


        $books = Book::when($title, function ($query, $title) {
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
}

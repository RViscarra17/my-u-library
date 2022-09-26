<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return \response($genres, Response::HTTP_OK);
    }
}

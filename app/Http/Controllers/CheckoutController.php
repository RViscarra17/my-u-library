<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutQueryRequest;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutResponse;
use App\Models\Book;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function index(CheckoutQueryRequest $request)
    {
        $user_id = $request->user_id;

        $checkouts = Checkout::when($user_id, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        })
            ->get()->load('user', 'book');
        return \response(CheckoutResponse::collection($checkouts), Response::HTTP_OK);
    }

    public function store(CheckoutRequest $request)
    {
        $user = $request->user();
        $bookCount = $user->checkouts()->where('book_id', $request->book_id)->where('returned', false)->count();
        if ($bookCount > 0) {
            return \response(['message' => 'You already checkout this book'], Response::HTTP_BAD_REQUEST);
        }

        $book = Book::find($request->book_id);
        if ($book->stock <= 0) {
            return \response(['message' => 'This book doesn\'t have stock'], Response::HTTP_BAD_REQUEST);
        }

        $request->merge(['user_id' => $user->id]);

        $checkout = Checkout::create($request->all());
        $book->stock -= 1;
        $book->save();
        return \response(new CheckoutResponse($checkout), Response::HTTP_CREATED);
    }

    public function update($id)
    {
        try {
            $checkout = Checkout::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return \response([
                'message' => 'Checkout Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($checkout->returned) {
            return \response(['message' => 'This book is already returned'], Response::HTTP_BAD_REQUEST);
        }

        $checkout->load('book', 'user');

        $checkout->returned = true;
        $checkout->book->stock += 1;
        $checkout->save();
        $checkout->book->save();

        return \response(new CheckoutResponse($checkout), Response::HTTP_OK);
    }
}

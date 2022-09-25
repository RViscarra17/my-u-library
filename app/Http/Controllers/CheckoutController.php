<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutQueryRequest;
use App\Http\Resources\CheckoutResponse;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function index(CheckoutQueryRequest $request)
    {
        $user_id = $request->user_id;

        $checkouts = Checkout::when($user_id, function($query, $user_id) {
                $query->where('user_id', $user_id);
            })
            ->get()->load('user', 'book');
        return \response(CheckoutResponse::collection($checkouts), Response::HTTP_OK);
    }
}

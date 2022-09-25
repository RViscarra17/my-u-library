<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return \response([
                'error' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }
        /** @var User $user */
        $user = Auth::user();

        // $userr = User::find($user->id);

        $jwt = $user->createToken('token')->plainTextToken;

        // dd ($user);
        $role = $user->getRoleNames()->implode(',');

        return \response([
            'token' => $jwt,
        ]);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user()->load('roles'));
    }
}

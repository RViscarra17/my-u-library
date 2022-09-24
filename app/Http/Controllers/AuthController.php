<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // return $credentials;

        if (!Auth::attempt($credentials)) {
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
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        $users = User::all()->load('roles');
        return \response(UserResource::collection($users), Response::HTTP_OK);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->except(['role', 'password_confirmation']));

        $user->syncRoles([$request->role]);

        return \response( new UserResource($user), Response::HTTP_CREATED);
    }
}
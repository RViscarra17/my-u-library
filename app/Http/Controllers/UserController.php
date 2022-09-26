<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserQueryRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //
    public function index(UserQueryRequest $request)
    {
        extract($request->all());

        $users = User::when($only_names, function($query) {
            $query->select('id', 'first_name', 'last_name');
        })
        ->get()
        ->load('roles');
        return \response(UserResource::collection($users), Response::HTTP_OK);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->except(['role_id', 'password_confirmation']));

        $user->syncRoles([$request->role_id]);

        return \response( new UserResource($user), Response::HTTP_CREATED);
    }

    public function indexRoles()
    {
        $roles = Role::all();
        return \response(RoleResource::collection($roles), Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

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
}

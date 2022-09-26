<?php

namespace App\Http\Controllers;

use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->getRoleNames();
        $routes = Route::role($role)->get();
        return \response(RouteResource::collection($routes), Response::HTTP_OK);
    }
}

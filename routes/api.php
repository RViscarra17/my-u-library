<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/user', [AuthController::class, 'user']);

    Route::prefix('users')->middleware(['role:librarian'])->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
    });

    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::middleware(['role:librarian'])->post('/', [BookController::class, 'store']);
        Route::get('/{id}', [BookController::class, 'show']);

    });

    Route::prefix('checkouts')->group(function() {
        Route::get('/', [CheckoutController::class, 'index']);
        Route::post('/', [CheckoutController::class, 'store']);
        Route::middleware(['role:librarian'])->put('/{id}', [CheckoutController::class, 'update']);
    });

    Route::get('/routes', [RouteController::class, 'index']);

    Route::get('/genres', [GenreController::class, 'index']);

    Route::get('/roles', [UserController::class, 'indexRoles']);
});

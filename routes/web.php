<?php

use App\RMVC\Route\Route;

use App\Http\Controllers\{
    HomeController,
    NotfoundController,
    BookController,
    GenreController,
    AuthorController,
    UserController,
    UserBookController
};

Route::get('/', [HomeController::class, 'index']);

Route::get('/notfound', [NotfoundController::class, 'index']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/create', [BookController::class, 'create']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/{id}/edit', [BookController::class, 'edit']);
Route::post('/books/{id}/update', [BookController::class, 'update']);
Route::post('/books/{id}/destroy', [BookController::class, 'destroy']);

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/create', [GenreController::class, 'create']);
Route::post('/genres', [GenreController::class, 'store']);
Route::get('/genres/{id}', [GenreController::class, 'show']);
Route::get('/genres/{id}/edit', [GenreController::class, 'edit']);
Route::post('/genres/{id}/update', [GenreController::class, 'update']);
Route::post('/genres/{id}/destroy', [GenreController::class, 'destroy']);

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/create', [AuthorController::class, 'create']);
Route::post('/authors', [AuthorController::class, 'store']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/authors/{id}/edit', [AuthorController::class, 'edit']);
Route::post('/authors/{id}/update', [AuthorController::class, 'update']);
Route::post('/authors/{id}/destroy', [AuthorController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::post('/users/{id}/update', [UserController::class, 'update']);
Route::post('/users/{id}/destroy', [UserController::class, 'destroy']);

Route::get('/userbooks', [UserBookController::class, 'index']);
Route::get('/userbooks/create', [UserBookController::class, 'create']);
Route::post('/userbooks', [UserBookController::class, 'store']);
Route::get('/userbooks/{id}', [UserBookController::class, 'show']);
Route::get('/userbooks/{id}/edit', [UserBookController::class, 'edit']);
Route::post('/userbooks/{id}/update', [UserBookController::class, 'update']);
Route::post('/userbooks/{id}/destroy', [UserBookController::class, 'destroy']);
<?php

use App\RMVC\Route\Route;

use App\Http\Controllers\Api\{
    BookController,
    AuthorController,
    GenreController,
    UserController,
    UserBookController
};

Route::get('/api/books', [BookController::class, 'index']);
Route::post('/api/books', [BookController::class, 'store']);
Route::get('/api/books/{id}', [BookController::class, 'show']);
Route::post('/api/books/{id}/update', [BookController::class, 'update']);
Route::post('/api/books/{id}/destroy', [BookController::class, 'destroy']);

Route::get('/api/authors', [AuthorController::class, 'index']);
Route::post('/api/authors', [AuthorController::class, 'store']);
Route::get('/api/authors/{id}', [AuthorController::class, 'show']);
Route::post('/api/authors/{id}/update', [AuthorController::class, 'update']);
Route::post('/api/authors/{id}/destroy', [AuthorController::class, 'destroy']);

Route::get('/api/genres', [GenreController::class, 'index']);
Route::post('/api/genres', [GenreController::class, 'store']);
Route::get('/api/genres/{id}', [GenreController::class, 'show']);
Route::post('/api/genres/{id}/update', [GenreController::class, 'update']);
Route::post('/api/genres/{id}/destroy', [GenreController::class, 'destroy']);

Route::get('/api/users', [UserController::class, 'index']);
Route::post('/api/users', [UserController::class, 'store']);
Route::get('/api/users/{id}', [UserController::class, 'show']);
Route::post('/api/users/{id}/update', [UserController::class, 'update']);
Route::post('/api/users/{id}/destroy', [UserController::class, 'destroy']);

Route::get('/api/userbooks', [UserBookController::class, 'index']);
Route::post('/api/userbooks', [UserBookController::class, 'store']);
Route::get('/api/userbooks/{id}', [UserBookController::class, 'show']);
Route::post('/api/userbooks/{id}/update', [UserBookController::class, 'update']);
Route::post('/api/userbooks/{id}/destroy', [UserBookController::class, 'destroy']);
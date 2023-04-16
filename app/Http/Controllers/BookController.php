<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View; 

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Services\BookService;
use App\Validator\BookValidator;

class BookController extends Controller
{

    /**
     * @var Book
     */
    protected Book $book;

     /**
     * @var Author
     */
    protected Author $author;

     /**
     * @var Genre
     */
    protected Genre $genre;

    /**
     * @var BookService
     */
    protected BookService $service;

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->book = new Book();
        $this->author = new Author();
        $this->genre = new Genre();
        $this->service = new BookService($this->book);
    }

    
    /**
     * @return string
     */
    public function index(): string
    {
        $books = $this->service->get();
        return View::view('book.index', compact('books'));
    }

    public function create(): string
    {
        $authors = $this->author->all();
        $genres = $this->genre->all();
        return View::view('book.create', compact('authors', 'genres'));
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $validator = new BookValidator($this->book);

        if ($validator->validate($this->data)) 
        {
            $this->service->create($this->data);
            Route::redirect('/books');
        }
        else
        {
            Route::redirect('/books/create');
        }
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function show(int $id): string
    {
        $book = $this->service->find($id);
        return View::view('book.show', compact('book'));
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function edit(int $id): string
    {
        $book = $this->service->find($id);
        $authors = $this->author->all();
        $genres = $this->genre->all();
        return View::view('book.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * @return void
     */
    public function update(int $id): void
    {
        $validator = new BookValidator($this->book);

        if ($validator->validate($this->data)) 
        {
            $this->service->update($this->data, $id);
            Route::redirect("/books/$id");
        }
        else
        {
            Route::redirect("/books/$id/edit");
        }
    }

    /**
     * @param int $id
     * 
     * @return void
     */
    public function destroy(int $id): void 
    {
        $this->service->destroy($id);
        Route::redirect('/books'); 
    }

}
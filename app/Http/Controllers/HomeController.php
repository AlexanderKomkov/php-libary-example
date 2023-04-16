<?php

namespace App\Http\Controllers;

use App\RMVC\View\View;

use App\Models\Book;
use App\Services\BookService;

class HomeController extends Controller
{
    /**
     * @var Book
     */
    protected Book $book;

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
        $this->service = new BookService($this->book);
    }


    public function index(): string
    {
        $books = $this->service->get();
        return View::view('home', compact('books'));
    }
}
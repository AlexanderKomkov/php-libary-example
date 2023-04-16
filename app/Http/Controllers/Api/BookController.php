<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\RMVC\Response\Response;

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
        return Response::json($this->service->get());
    }

    /**
     * @return void
     */
    public function store(): string
    {
        $validator = new BookValidator($this->book);

        if (!$validator->validate($this->data)) return Response::json($validator->getErrors());
        
        return Response::json($this->service->create($this->data));
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function show(int $id): string
    {
        return Response::json($this->service->find($id));
    }

    /**
     * @return void
     */
    public function update(int $id): string
    {
        $validator = new BookValidator($this->book);

        if (!$validator->validate($this->data)) return Response::json($validator->getErrors());
   
        return Response::json($this->service->update($this->data, $id));
    }

    /**
     * @param int $id
     * 
     * @return void
     */
    public function destroy(int $id): string 
    {
        return Response::json($this->service->destroy($id));
    }

}
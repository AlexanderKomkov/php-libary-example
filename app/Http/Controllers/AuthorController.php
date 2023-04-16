<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View; 

use App\Models\Author;
use App\Services\AuthorService;
use App\Validator\AuthorValidator;

class AuthorController extends Controller
{

    /**
     * @var Author
     */
    protected Author $author;

    /**
     * @var AuthorService
     */
    protected AuthorService $service;

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->author = new Author();
        $this->service = new AuthorService($this->author);
    }

    
    /**
     * @return string
     */
    public function index(): string
    {
        $authors = $this->service->get();
        return View::view('author.index', compact('authors'));
    }

    public function create(): string
    {
        return View::view('author.create');
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $validator = new AuthorValidator($this->author);

        if ($validator->validate($this->data)) 
        {
            $this->service->create($this->data);
            Route::redirect('/authors');
        }
        else
        {
            Route::redirect('/authors/create');
        }
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function show(int $id): string
    {
        $author = $this->service->find($id);
        return View::view('author.show', compact('author'));
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function edit(int $id): string
    {
        $author = $this->service->find($id);
        return View::view('author.edit', compact('author'));
    }

    /**
     * @return void
     */
    public function update(int $id): void
    {
        $validator = new AuthorValidator($this->author);

        if ($validator->validate($this->data)) 
        {
            $this->service->update($this->data, $id);
            Route::redirect("/authors/$id");
        }
        else
        {
            Route::redirect("/authors/$id/edit");
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
        Route::redirect('/authors'); 
    }

}
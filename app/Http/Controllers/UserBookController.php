<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View; 

use App\Models\UserBook;
use App\Models\Book;
use App\Models\User;
use App\Services\UserBookService;
use App\Validator\UserBookValidator;

class UserBookController extends Controller
{

    /**
     * @var UserBook
     */
    protected UserBook $userBook;

     /**
     * @var Book
     */
    protected Book $book;

     /**
     * @var User
     */
    protected User $user;

    /**
     * @var UserBookService
     */
    protected UserBookService $service;

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->userBook = new UserBook();
        $this->book = new Book();
        $this->user = new User();
        $this->service = new UserBookService($this->userBook);
    }
    
    /**
     * @return string
     */
    public function index(): string
    {
        $userBooks = $this->service->get();
        return View::view('userbook.index', compact('userBooks'));
    }

    public function create(): string
    {
        $books = $this->book->all();
        $users = $this->user->all();
        return View::view('userbook.create', compact('books', 'users'));
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $validator = new UserBookValidator($this->userBook);

        if ($validator->validate($this->data)) 
        {
            $this->service->create($this->data);
            Route::redirect('/userbooks');
        }
        else
        {
            Route::redirect('/userbooks/create');
        }
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function show(int $id): string
    {
        $userBook = $this->service->find($id);
        return View::view('userbook.show', compact('userBook'));
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function edit(int $id): string
    {
        $userBook = $this->service->find($id);
        $users = $this->user->all();
        $books = $this->book->all();
        return View::view('userbook.edit', compact('userBook', 'users', 'books'));
    }

    /**
     * @return void
     */
    public function update(int $id): void
    {
        $validator = new UserBookValidator($this->userBook);

        if ($validator->validate($this->data)) 
        {
            $this->service->update($this->data, $id);
            Route::redirect("/userbooks/$id");
        }
        else
        {
            Route::redirect("/userbooks/$id/edit");
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
        Route::redirect('/userbooks'); 
    }

}
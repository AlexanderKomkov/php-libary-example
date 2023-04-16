<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View; 

use App\Models\User;
use App\Services\UserService;

use App\Validator\User\StoreValidator;
use App\Validator\User\UpdateValidator;

class UserController extends Controller
{

    /**
     * @var User
     */
    protected User $user;

    /**
     * @var UserService
     */
    protected UserService $service;

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->service = new UserService($this->user);
    }

    
    /**
     * @return string
     */
    public function index(): string
    {
        $users = $this->service->get();
        return View::view('user.index', compact('users'));
    }

    public function create(): string
    {
        return View::view('user.create');
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $validator = new StoreValidator($this->user);

        if ($validator->validate($this->data)) 
        {
            $this->service->create($this->data);
            Route::redirect('/users');
        }
        else
        {
            Route::redirect('/users/create');
        }
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function show(int $id): string
    {
        $user = $this->service->find($id);
        return View::view('user.show', compact('user'));
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function edit(int $id): string
    {
        $user = $this->service->find($id);
        return View::view('user.edit', compact('user'));
    }

    /**
     * @return void
     */
    public function update(int $id): void
    {
        $validator = new UpdateValidator($this->user, $id);

        if ($validator->validate($this->data)) 
        {
            $this->service->update($this->data, $id);
            Route::redirect("/users/$id");
        }
        else
        {
            Route::redirect("/users/$id/edit");
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
        Route::redirect('/users'); 
    }

}
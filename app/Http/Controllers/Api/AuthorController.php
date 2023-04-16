<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\RMVC\Response\Response;

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
        return Response::json($this->service->get());
    }

    /**
     * @return void
     */
    public function store(): string
    {
        $validator = new AuthorValidator($this->author);

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
        $validator = new AuthorValidator($this->author);

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
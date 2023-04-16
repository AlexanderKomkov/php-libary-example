<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\RMVC\Response\Response;

use App\Models\UserBook;

use App\Services\UserBookService;

use App\Validator\UserBookValidator;

class UserBookController extends Controller
{

    /**
     * @var UserBook
     */
    protected UserBook $userBook;

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
        $this->service = new UserBookService($this->userBook);
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
        $validator = new UserBookValidator($this->userBook);

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
        $validator = new UserBookValidator($this->userBook);

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
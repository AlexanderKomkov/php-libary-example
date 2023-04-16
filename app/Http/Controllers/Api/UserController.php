<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\RMVC\Response\Response;

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
     *
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
        return Response::json($this->service->get());
    }

    /**
     * @return string
     */
    public function store(): string
    {
        $validator = new StoreValidator($this->user);

        if (!$validator->validate($this->data)) return Response::json($validator->getErrors());

        return Response::json($this->service->create($this->data));
    }

    /**
     * @param $id
     * @return string
     */
    public function show($id): string
    {
        return Response::json($this->service->find($id));
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function update($id): string
    {
        $validator = new UpdateValidator($this->user, $id);

        if (!$validator->validate($this->data)) return Response::json($validator->getErrors());

        return Response::json($this->service->update($this->data, $id));
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id): string
    {
        return Response::json($this->service->destroy($id));
    }
}
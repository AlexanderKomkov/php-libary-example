<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\RMVC\Response\Response;

use App\Models\Genre;
use App\Services\GenreService;
use App\Validator\GenreValidator;

class GenreController extends Controller
{

    /**
     * @var Genre
     */
    protected Genre $genre;

    /**
     * @var GenreService
     */
    protected GenreService $service;

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->genre = new Genre();
        $this->service = new GenreService($this->genre);
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
        $validator = new GenreValidator($this->genre);

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
        $validator = new GenreValidator($this->genre);

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
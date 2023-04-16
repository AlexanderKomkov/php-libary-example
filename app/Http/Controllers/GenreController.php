<?php

namespace App\Http\Controllers;

use App\RMVC\Route\Route;
use App\RMVC\View\View; 

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
        $genres = $this->service->get();
        return View::view('genre.index', compact('genres'));
    }

    public function create(): string
    {
        return View::view('genre.create');
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $validator = new GenreValidator($this->genre);

        if ($validator->validate($this->data)) 
        {
            $this->service->create($this->data);
            Route::redirect('/genres');
        }
        else
        {
            Route::redirect('/genres/create');
        }
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function show(int $id): string
    {
        $genre = $this->service->find($id);
        return View::view('genre.show', compact('genre'));
    }

    /**
     * @param int $id
     * 
     * @return string
     */
    public function edit(int $id): string
    {
        $genre = $this->service->find($id);
        return View::view('genre.edit', compact('genre'));
    }

    /**
     * @return void
     */
    public function update(int $id): void
    {
        $validator = new GenreValidator($this->genre);

        if ($validator->validate($this->data)) 
        {
            $this->service->update($this->data, $id);
            Route::redirect("/genres/$id");
        }
        else
        {
            Route::redirect("/genres/$id/edit");
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
        Route::redirect('/genres'); 
    }

}
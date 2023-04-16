<?php

namespace App\Http\Controllers;

use App\RMVC\View\View;

class NotfoundController extends Controller
{

    public function index(): string
    {
        http_response_code(404);
        return View::view('notfound');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServerFakeController extends Controller
{

    public function index()
    {
        return response(['success' => 'Deu certo!'], Response::HTTP_OK);
    }
}

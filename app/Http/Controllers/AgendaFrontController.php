<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaFrontController extends Controller
{
    public function index(Request $request)
    {
        return view('front.agenda-index');
    }
}

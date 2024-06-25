<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopFrontController extends Controller
{
    public function index()
    {
        return view('front.top-index');
    }

    public function temp(){

        return view('top.welcome');
    }
}

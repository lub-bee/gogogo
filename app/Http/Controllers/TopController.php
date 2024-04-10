<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function index()
    {
        return view('top/welcome');
    }

    public function user()
    {
        dd("todo");
    }

    public function event()
    {
        dd("todo");
    }

    public function location()
    {
        dd("todo");
    }

    public function topic()
    {
        dd("todo");
    }
}

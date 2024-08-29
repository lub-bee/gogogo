<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopFrontController extends Controller
{
    public function index()
    {
        $greetingsService = new \App\Services\GreetingsService();

        return view('front.top-index')
            ->with('greetings', $greetingsService->hello());
    }

    public function temp(){

        return view('top.welcome');
    }
}

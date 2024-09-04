<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class TopFrontController extends Controller
{
    public function index()
    {
        $greetingsService = new \App\Services\GreetingsService();

        //get the next upcoming event
        $event = Event::where("start_at", ">=", now())->isPublished()->first();

        //if there is no upcoming event, get the first published event
        if (!$event) {
            $event = Event::where("start_at", "<=", now())->isPublished()->first();
        }

        return view('front.top-index')
            ->with('greetings', $greetingsService->hello())
            ->with('event', $event);
    }

    public function temp(){

        return view('top.welcome');
    }
}

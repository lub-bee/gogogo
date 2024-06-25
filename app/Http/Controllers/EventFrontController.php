<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventFrontController extends Controller
{
    public function index(Request $request){
        //displays list of events
        return view("front.event-index");
    }

    public function show(string $event_slug){
        //display a specific event
        return view("front.event-show");
    }
}

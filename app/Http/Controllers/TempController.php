<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TempController extends Controller
{
    /**
     * Event
     * @param
     *
     */
    function event()
    {

        return view('temp.event');
    }
    //Agenda
    function agenda()
    {
        return view('temp.agenda');


    }
    //Topic
    function topic()
    {
        return view('temp.topic');


    }
    //Media
    function media()
    {
        return view('temp.media');


    }
    //Location
    function location()
    {
        return view('temp.location');


    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Topic;
use Illuminate\Http\Request;


class TempController extends Controller
{
    /**
     * Event
     * @param
     *
     */
    function event(int $event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('temp.event')
            ->with('event', $event);
    }
    //Agenda
    function agenda()
    {
        return view('temp.agenda');


    }
    //Topic
    function topic(Topic $topic)
    {
        return view('temp.topic')
            ->with("topic", $topic);


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

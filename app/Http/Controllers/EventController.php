<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Type\Integer;

class EventController extends Controller
{

    //show all -> index
    public function index()
    {
        $events = Event::all();//todo order?
        return view("admin/event/index")
            ->with("events", $events);
    }

    public function show(int $event_id)
    {
        $event = Event::findOrFail($event_id);
        return view("admin/event/show")
            ->with("event", $event);
    }

    //create -> create
    public function create()
    {
    ////HELP - CREATING
        // $event = Event ;
        return view("admin/event/create");
    }

    //Store in the DB -> store
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description_en" => [
                "nullable",
                "string",
                "max:20000"
            ],
            "cost" => "numeric|nullable|max:90000",
            // "user_id" => "required|exists:users,id"
        ]);


        $event = new Event();
        $event->name = $validated["name"];
        // $event->end_at = $request->input("end_at");
        // $event->end_at = $request->input("end_at");
        $event->description_en = $validated["description_en"];
        // $event->description_ja = $request->input("description_ja");
        $event->cost = $validated["cost"];

        $event->user_id = auth()->user()->id;
        // dd($event);

        // $event->topic_id = $request->input("topic_id");
        // $event->location_id = $request->input("location_id");

        $event->save();

        return redirect()->route("event.show", $event->id);
    }

    //edit -> edit
    public function edit($event_id)
    {
        return view("admin/event/edit");
    }

    //update
    public function update(Request $request)
    {

    }

    //delete
    public function delete(Request $request)
    {

    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventDeleteRequest;
use App\Http\Requests\EventPublishRequest;
use App\Models\Event;
use App\Models\Location;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View as ViewView;
use Ramsey\Uuid\Type\Integer;


class EventController extends Controller
{

    /**
     * Display event list
     *
     * @return View
     */
    public function index(): View
    {
        $events = Event::orderBy("start_at","desc")
            ->orderBy('name',"asc")->get();

        return view("admin/event/index")
            ->with("events", $events);
    }

    /**
     * Display one specific event detail
     *
     * @return View
     */
    public function show(int $event_id) : View
    {
        $event = Event::findOrFail($event_id);

        return view("admin/event/show")
            ->with("event", $event);
    }

    /**
     * Display create form
     *
     * @return View
     */
    public function create() : View
    {
        return view("admin/event/create")
            ->with("topics", Topic::get())
            ->with("locations", Location::get());
    }

    /**
     * Store new event instance
     *
     * @param EventCreateRequest $request
     * @return RedirectResponse
     */
    public function store(EventCreateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $event = new Event();
        $event->name = $validated["name"];
        $event->start_at = $validated['start_at'];
        $event->end_at = $validated['end_at'];
        $event->description_en = $validated["description_en"];
        $event->description_ja = $validated["description_ja"];
        $event->cost = $validated["cost"];

        if($validated["status"] == "published"){
            $event->published_at = $validated["published_at"];
        }

        $event->user_id = auth()->user()->id; //automatically design the author
        $event->topic_id = $validated["topic_id"];
        $event->location_id = $validated["location_id"];

        // $event->location_id = Location::location()->id; //todo

        $event->save();

        return redirect(route('event.index'))
            ->with("success", "Event saved successfully");
    }

    /**
     * Display edit form
     *
     * @param int $event_id
     * @return View
     */
    public function edit(int $event_id): View
    {
        $event = Event::findOrFail($event_id);
        $topics = Topic::get();
        $locations = Location::get();

        return view("admin/event/edit")
                ->with('event', $event)
                ->with('topics', $topics)
                ->with('locations', $locations);
    }

    /**
     * Update a specific event
     *
     * @param int $event_id
     * @param EventCreateRequest $request
     * @return RedirectResponse
     */
    public function update(int $event_id, EventCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $event = Event::find($event_id);
        $event->name = $validated["name"];
        $event->start_at = $validated['start_at'];
        $event->end_at = $validated['end_at'];
        $event->description_en = $validated["description_en"];
        $event->description_ja = $validated["description_ja"];
        $event->cost = $validated["cost"];
        $event->topic_id = $validated["topic_id"];
        $event->location_id = $validated["location_id"];

        if($validated["status"] == "published"){
            $event->published_at = $validated["published_at"];
        } else {
            $event->published_at = null;
        }
        $event->save();

        return redirect(route("event.show", $event->id))
            ->with("success", "Event updated successfully");
    }

    /**
     * Publish a specific Event
     * @param Event $event
     * @param EventPublishRequest $request
     * @return RedirectResponse
     */
    public function publish(Event $event, EventPublishRequest $request) : RedirectResponse
    {
        $event->published_at = now();
        $event->save();
        return redirect(route("event.show", $event->id))
            ->with('success',"Event [$event->name] published successfully");
    }

    /**
     * Delete a specific event
     *
     * @param EventDeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(EventDeleteRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $event = Event::findOrFail($validated['event_id']);
        $event->delete();

        return redirect(route("event.index"))
            ->with('success',"Event [$event->name] deleted successfully");
    }

}

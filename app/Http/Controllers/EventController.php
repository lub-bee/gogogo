<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventDeleteRequest;
use App\Models\Event;
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
        // $event->user();

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
        return view("admin/event/create");
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
        $event->status = $validated["status"];
        $event->cost = $validated["cost"];

        if($validated["status"] == "published"){
            $event->published_at = $validated["published_at"];
        }

        $event->user_id = auth()->user()->id; //automatically design the author

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
        return view("admin/event/edit")
                ->with('event', $event);
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

<?php

namespace App\Http\Controllers\Management;

use App\Enums\EventType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\StoreEventRequest;
use App\Http\Requests\Management\UpdateEventRequest;
use App\Models\Event;
use App\Models\Location;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['location', 'topic'])
            ->withCount('attendees');

        // Filter by publication status
        if ($status = $request->query('status')) {
            match ($status) {
                'draft' => $query->whereNull('published_at'),
                'scheduled' => $query->whereNotNull('published_at')->where('published_at', '>', now()),
                'published' => $query->whereNotNull('published_at')->where('published_at', '<=', now()),
                default => null,
            };
        }

        $events = $query->orderByDesc('start_at')->paginate(20)->withQueryString();

        return view('management.events.index', compact('events', 'status'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);

        return view('management.events.create', [
            'types' => EventType::cases(),
            'locations' => Location::orderBy('name')->get(),
            'topics' => Topic::doesntHave('events')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = new Event($request->validated());
        $event->user_id = $request->user()->id;
        $event->save();

        return redirect()->route('management.events.index')
            ->with('status', "Event \"{$event->name}\" created.");
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        // Topics: those without an event, PLUS the one already linked to this event
        $topics = Topic::where(function ($q) use ($event) {
            $q->doesntHave('events');
            if ($event->topic_id) {
                $q->orWhere('id', $event->topic_id);
            }
        })->orderBy('name')->get();

        return view('management.events.edit', [
            'event' => $event,
            'types' => EventType::cases(),
            'locations' => Location::orderBy('name')->get(),
            'topics' => $topics,
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->fill($request->validated());
        $event->save();

        return redirect()->route('management.events.index')
            ->with('status', "Event \"{$event->name}\" updated.");
    }

    public function publish(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->publish();

        return back()->with('status', "Event \"{$event->name}\" published.");
    }

    public function unpublish(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->update(['published_at' => null]);

        return back()->with('status', "Event \"{$event->name}\" unpublished (back to draft).");
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $name = $event->name;
        $event->delete();

        return redirect()->route('management.events.index')
            ->with('status', "Event \"{$name}\" deleted.");
    }
}

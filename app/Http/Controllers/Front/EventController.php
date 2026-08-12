<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Request $request, Event $event)
    {
        // Guests and members: only published events; admin/support: all
        $user = $request->user();
        if (! $event->isPublished()) {
            if (! $user || ! $user->hasRank('admin', 'support')) {
                abort(404);
            }
        }

        $event->load(['topic', 'location', 'attendees']);

        // Prev/Next among published events (chronological)
        $prev = Event::published()
            ->where('start_at', '<', $event->start_at)
            ->orderByDesc('start_at')
            ->first();
        $next = Event::published()
            ->where('start_at', '>', $event->start_at)
            ->orderBy('start_at')
            ->first();

        $isAttending = $user ? $event->attendees->contains($user->id) : false;

        return view('front.event-show', [
            'event' => $event,
            'prevEventUrl' => $prev ? url('/event/' . $prev->slug) : null,
            'nextEventUrl' => $next ? url('/event/' . $next->slug) : null,
            'isAttending' => $isAttending,
        ]);
    }

    public function rsvp(Request $request, Event $event)
    {
        $user = $request->user();

        if (! $event->isPublished()) {
            abort(404);
        }

        $event->attendees()->toggle($user->id);

        return back();
    }
}

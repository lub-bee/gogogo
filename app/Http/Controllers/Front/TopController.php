<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Location;
use App\Models\Media;
use App\Models\Topic;
use App\Enums\MediaStatus;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function __invoke(Request $request)
    {
        // Upcoming event: next published event in the future, or most recent published
        $event = Event::published()
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->with(['topic', 'location'])
            ->first();

        if (! $event) {
            $event = Event::published()
                ->orderByDesc('start_at')
                ->with(['topic', 'location'])
                ->first();
        }

        // Prev/Next event navigation (chronological)
        $prevEventUrl = null;
        $nextEventUrl = null;
        if ($event) {
            $prev = Event::published()
                ->where('start_at', '<', $event->start_at)
                ->orderByDesc('start_at')
                ->first();
            $next = Event::published()
                ->where('start_at', '>', $event->start_at)
                ->orderBy('start_at')
                ->first();
            $prevEventUrl = $prev ? url('/event/' . $prev->slug) : null;
            $nextEventUrl = $next ? url('/event/' . $next->slug) : null;
        }

        // Agenda: upcoming published events — at most 3 months ahead or 9 events
        $agendaEvents = Event::published()
            ->where('start_at', '>=', now()->startOfMonth())
            ->where('start_at', '<', now()->startOfMonth()->addMonths(3))
            ->orderBy('start_at')
            ->limit(9)
            ->get();

        $agendaMonths = $agendaEvents->groupBy(fn ($e) => $e->start_at->format('Y-m'))
            ->map(fn ($events, $key) => [
                'name' => strtoupper($events->first()->start_at->format('M')),
                'events' => $events->map(fn ($e) => [
                    'day' => $e->start_at->format('d'),
                    'icon' => $e->type->value === 'special' ? 'fa-mug-hot' : 'fa-book',
                    'title' => $e->name,
                    'slug' => $e->slug,
                ])->values()->all(),
            ])
            ->values()
            ->all();

        // Topics: latest 4 published topics
        $topics = Topic::published()
            ->orderByDesc('published_at')
            ->limit(4)
            ->get()
            ->map(fn ($t) => [
                'name' => $t->name,
                'slug' => $t->slug,
                'description_en' => $t->description_en,
                'description_ja' => $t->description_ja,
                'published_at' => $t->published_at?->format('Y-m-d'),
            ])
            ->all();

        // Photos: latest approved media
        $photos = Media::where('status', MediaStatus::Approved)
            ->with('event')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(fn ($m) => [
                'title' => $m->event?->name ?? 'Photo',
                'date' => $m->created_at->format('d M Y'),
                'width' => rand(150, 320),
                'height' => rand(180, 260),
                'bg' => 'rgb(71 85 105)',
                'icon' => 'fa-image',
            ])
            ->all();

        // Locations: ordered by event count
        $locations = Location::withCount('events')
            ->orderByDesc('events_count')
            ->limit(6)
            ->get()
            ->map(fn ($l) => [
                'icon' => 'fa-location-dot',
                'name' => $l->name,
                'slug' => $l->slug,
                'count' => $l->events_count,
            ])
            ->all();

        return view('front.top', [
            'event' => $event,
            'prevEventUrl' => $prevEventUrl,
            'nextEventUrl' => $nextEventUrl,
            'agendaMonths' => $agendaMonths,
            'topics' => $topics,
            'photos' => $photos,
            'locations' => $locations,
        ]);
    }
}

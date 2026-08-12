<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('events')
            ->orderByDesc('events_count')
            ->get()
            ->map(fn ($l) => [
                'icon' => 'fa-location-dot',
                'name' => $l->name,
                'slug' => $l->slug,
                'count' => $l->events_count,
            ])
            ->all();

        return view('front.location-index', [
            'locations' => $locations,
        ]);
    }

    public function show(Location $location)
    {
        $location->loadCount('events');

        $upcomingEvents = $location->events()
            ->published()
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->get()
            ->map(fn ($e) => [
                'date' => strtoupper($e->start_at->format('M d')),
                'icon' => $e->type->value === 'special' ? 'fa-mug-hot' : 'fa-book',
                'title' => $e->name,
                'slug' => $e->slug,
            ])
            ->all();

        $pastEvents = $location->events()
            ->published()
            ->where('start_at', '<', now())
            ->orderByDesc('start_at')
            ->limit(20)
            ->get()
            ->map(fn ($e) => [
                'date' => strtoupper($e->start_at->format('M d')),
                'icon' => $e->type->value === 'special' ? 'fa-mug-hot' : 'fa-book',
                'title' => $e->name,
                'slug' => $e->slug,
            ])
            ->all();

        return view('front.location-show', [
            'location' => $location,
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
        ]);
    }
}

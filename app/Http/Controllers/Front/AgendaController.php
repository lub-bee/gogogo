<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        // For API-driven infinite scroll: return JSON when requested
        if ($request->wantsJson()) {
            $events = Event::published()
                ->orderByDesc('start_at')
                ->paginate(20);

            $grouped = $events->getCollection()
                ->groupBy(fn ($e) => $e->start_at->format('Y-m'))
                ->map(fn ($events, $key) => [
                    'type' => 'month',
                    'year' => $events->first()->start_at->format('Y'),
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

            return response()->json([
                'months' => $grouped,
                'next_page' => $events->nextPageUrl(),
            ]);
        }

        return view('front.agenda-index');
    }
}

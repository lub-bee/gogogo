<?php

namespace App\Http\Controllers\Front;

use App\Enums\MediaStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::where('status', MediaStatus::Approved)
            ->with('event')
            ->orderByDesc('created_at');

        $filteredEvent = null;

        if ($request->filled('event')) {
            $filteredEvent = Event::where('slug', $request->input('event'))->first();
            if ($filteredEvent) {
                $query->where('event_id', $filteredEvent->id);
            }
        }

        $mediaItems = $query->paginate(30);

        $photos = $mediaItems->getCollection()
            ->map(fn ($m) => [
                'title' => $m->event?->name ?? 'Photo',
                'date' => strtoupper($m->created_at->format('d M Y')),
                'thumb' => $m->thumbnail_path ? asset('storage/' . $m->thumbnail_path) : null,
                'full' => $m->path ? asset('storage/' . $m->path) : null,
                'legend' => $m->legend,
            ])
            ->all();

        return view('front.media-index', [
            'photos' => $photos,
            'mediaItems' => $mediaItems,
            'filteredEvent' => $filteredEvent,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\MediaStatus;
use App\Models\Event;
use App\Models\Media;
use App\Services\ImagePipeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MediaUploadController extends Controller
{
    /**
     * Store one or more uploaded images.
     *
     * Entry points:
     * - From profile "My Media" section (event_id selected via picker)
     * - From an event page (event_id from route)
     */
    public function store(Request $request, ImagePipeline $pipeline): RedirectResponse
    {
        Gate::authorize('create', Media::class);

        $request->validate([
            'images' => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => ['required', 'file', 'mimes:jpeg,jpg,png,webp,heic', 'max:20480'],
            'event_id' => ['required', 'exists:events,id'],
            'legend' => ['nullable', 'string', 'max:255'],
        ]);

        $event = Event::findOrFail($request->input('event_id'));

        foreach ($request->file('images') as $file) {
            $paths = $pipeline->process($file);

            Media::create([
                'path' => $paths['path'],
                'thumbnail_path' => $paths['thumbnail_path'],
                'legend' => $request->input('legend'),
                'status' => MediaStatus::Pending,
                'user_id' => $request->user()->id,
                'event_id' => $event->id,
            ]);
        }

        return back()->with('status', 'media-uploaded');
    }
}

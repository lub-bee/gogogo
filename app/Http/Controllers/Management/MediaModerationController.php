<?php

namespace App\Http\Controllers\Management;

use App\Enums\MediaStatus;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MediaModerationController extends Controller
{
    /**
     * Moderation inbox: pending media as a grid of thumbnails.
     */
    public function index()
    {
        $pending = Media::where('status', MediaStatus::Pending)
            ->with(['user', 'event'])
            ->orderBy('created_at')
            ->get();

        return view('management.media-moderation', [
            'pending' => $pending,
        ]);
    }

    /**
     * Approve a single media item.
     */
    public function approve(Media $media): RedirectResponse
    {
        Gate::authorize('update', $media);

        $media->approve();

        return back()->with('status', 'media-approved');
    }

    /**
     * Refuse a single media item (deletes original file).
     */
    public function refuse(Media $media): RedirectResponse
    {
        Gate::authorize('update', $media);

        $media->refuse();

        return back()->with('status', 'media-refused');
    }

    /**
     * Bulk approve or refuse selected media items.
     */
    public function bulk(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:approve,refuse'],
            'media_ids' => ['required', 'array', 'min:1'],
            'media_ids.*' => ['integer', 'exists:media,id'],
        ]);

        $action = $request->input('action');
        $items = Media::whereIn('id', $request->input('media_ids'))
            ->where('status', MediaStatus::Pending)
            ->get();

        foreach ($items as $media) {
            Gate::authorize('update', $media);

            if ($action === 'approve') {
                $media->approve();
            } else {
                $media->refuse();
            }
        }

        $count = $items->count();
        $verb = $action === 'approve' ? 'approved' : 'refused';

        return back()->with('status', "{$count} media {$verb}");
    }
}

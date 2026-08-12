<?php

namespace App\Http\Controllers\Management;

use App\Enums\MediaStatus;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MediaModerationController extends Controller
{
    /**
     * Media management with tabs: Pending (inbox), Approved, Refused.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');
        $status = match ($tab) {
            'approved' => MediaStatus::Approved,
            'refused' => MediaStatus::Refused,
            default => MediaStatus::Pending,
        };

        $media = Media::where('status', $status)
            ->with(['user', 'event'])
            ->orderByDesc('created_at')
            ->paginate(40)
            ->withQueryString();

        $counts = [
            'pending' => Media::where('status', MediaStatus::Pending)->count(),
            'approved' => Media::where('status', MediaStatus::Approved)->count(),
            'refused' => Media::where('status', MediaStatus::Refused)->count(),
        ];

        return view('management.media-moderation', [
            'media' => $media,
            'tab' => $tab,
            'counts' => $counts,
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
     * Re-refuse an approved media item (e.g. content found inappropriate after initial approval).
     * This deletes the original file and sets status to refused.
     */
    public function reRefuse(Media $media): RedirectResponse
    {
        Gate::authorize('update', $media);

        if ($media->status !== MediaStatus::Approved) {
            return back()->with('error', 'Only approved media can be re-refused.');
        }

        $media->refuse();

        return back()->with('status', 'Approved media re-refused. Original file deleted.');
    }

    /**
     * Delete a media record entirely (removes files from storage too).
     */
    public function destroy(Media $media): RedirectResponse
    {
        Gate::authorize('delete', $media);

        // Clean up files
        if ($media->path && Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }
        if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();

        return back()->with('status', 'Media deleted.');
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

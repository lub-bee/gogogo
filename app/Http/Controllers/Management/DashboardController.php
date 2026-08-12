<?php

namespace App\Http\Controllers\Management;

use App\Enums\MediaStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Media;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $pendingMediaCount = Media::where('status', MediaStatus::Pending)->count();

        $upcomingEvents = Event::published()
            ->where('start_at', '>=', Carbon::now())
            ->orderBy('start_at')
            ->with('location')
            ->withCount('attendees')
            ->limit(5)
            ->get();

        $draftEventsCount = Event::whereNull('published_at')->count();
        $draftTopicsCount = Topic::whereNull('published_at')->count();

        $recentRsvps = \DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->join('events', 'attendances.event_id', '=', 'events.id')
            ->orderByDesc('attendances.created_at')
            ->limit(10)
            ->select('users.name as user_name', 'events.name as event_name', 'events.slug as event_slug', 'attendances.created_at')
            ->get();

        $data = compact('pendingMediaCount', 'upcomingEvents', 'draftEventsCount', 'draftTopicsCount', 'recentRsvps');

        // Admin-only: total members count
        if ($request->user()->isAdmin()) {
            $data['totalMembers'] = User::count();
        }

        return view('management.dashboard', $data);
    }
}

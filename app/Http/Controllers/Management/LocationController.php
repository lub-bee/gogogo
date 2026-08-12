<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\StoreLocationRequest;
use App\Http\Requests\Management\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('events')
            ->orderBy('name')
            ->paginate(20);

        return view('management.locations.index', compact('locations'));
    }

    public function create()
    {
        $this->authorize('create', Location::class);

        return view('management.locations.create');
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $location = new Location($request->validated());
        $location->user_id = $request->user()->id;
        $location->save();

        return redirect()->route('management.locations.index')
            ->with('status', "Location \"{$location->name}\" created.");
    }

    public function edit(Location $location)
    {
        $this->authorize('update', $location);

        $location->loadCount('events');

        return view('management.locations.edit', compact('location'));
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $location->fill($request->validated());
        $location->save();

        return redirect()->route('management.locations.index')
            ->with('status', "Location \"{$location->name}\" updated.");
    }

    public function destroy(Location $location): RedirectResponse
    {
        $this->authorize('delete', $location);

        $name = $location->name;
        $eventsCount = $location->events()->count();

        if ($eventsCount > 0) {
            // Warn — FK is SET NULL, events will lose their location reference
            $location->delete();

            return redirect()->route('management.locations.index')
                ->with('status', "Location \"{$name}\" deleted. {$eventsCount} event(s) had their location cleared (set to none).");
        }

        $location->delete();

        return redirect()->route('management.locations.index')
            ->with('status', "Location \"{$name}\" deleted.");
    }
}

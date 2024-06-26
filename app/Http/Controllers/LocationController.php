<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationCreateRequest;
use App\Http\Requests\LocationDeleteRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display location list
     *
     * @return View
     */
    public function index() : View
    {
        $locations = Location::orderBy("cost", "desc")
            ->orderBy("name", "asc")->get();

        return view("admin.location.index")
            ->with("locations", $locations);

    }

    /**
     * Display one specific location
     *
     * @return View
     */
    public function show(int $location_id) : View
    {
        $location = Location::findOrFail($location_id);

        return view("admin/location/show")
           ->with("location", $location);

    }

/**
 * Display the create form
 *
 * @return View
 */
    public function create() : View
    {
        return view("admin.location.create");

    }

    /**
     * Store a new location
     *
     * @param LocationCreateRequest $request
     * @return RedirectResponse
     */
    public function store(LocationCreateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $location = new Location();
        $location->name = $validated["name"];
        $location->description_en = $validated["description_en"];
        $location->gps_long = $validated["gps_long"];
        $location->gps_lat = $validated["gps_lat"];
        $location->website_url = $validated["website_url"];
        $location->cost = $validated["cost"];
        $location->user_id = auth()->user()->id;
        $location->save();

        return redirect(route("location.index"))
            ->with("success", "Location saved successfully");
    }

    /**
     * Display the edit form
     *
     * @param int $location_id
     * @return View
     */
    public function edit(int $location_id) : View
    {
        $location = Location::findOrFail($location_id);
        return view("admin.location.edit")
            ->with('location', $location);
    }

    /**
     * Update a specific location
     *
     * @param int $location_id
     * @param LocationCreateRequest $request
     * @return RedirectResponse
     */
    public function update(int $location_id, LocationCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $location = Location::find($location_id);
        $location->name = $validated["name"];
        $location->description_en = $validated["description_en"];
        $location->gps_long = $validated["gps_long"];
        $location->gps_lat = $validated["gps_lat"];
        $location->website_url = $validated["website_url"];
        $location->cost = $validated["cost"];

        $message = "Nothing to update";

        // check if anything changed, to avoid unnecessary saving
        if($location->isDirty()){
            $location->save();
            $message = "Location updated successfully";
        }

        //  TO CHECK - $location->user_id = auth()->user()->id;

        return redirect(route("location.show", $location->id))
            ->with("success", $message);
    }

    /**
     * Delete a specific location
     *
     * @param LocationDeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(LocationDeleteRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $location = Location::findOrFail($validated['location_id']);
        $location->delete();

        return redirect(route("location.index"))
            ->with('success', "Location [$location->name} deleted successfully");
    }
}

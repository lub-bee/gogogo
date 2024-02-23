<?php

namespace App\Http\Controllers;

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
 */
    function create() : View
    {
        return view("admin.location.create");

    }

    /**
     * Store a new location
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => [
                "required",
                "string",
                "max:255"
            ],
            "description_en" => [
                "nullable",
                "string",
                "max:2000"
            ],
            "description_ja" => [
                "nullable",
                "string",
                "max:2000"
            ],
            "gps_long" => [
                "nullable",
                "string",
                "max:15"
            ],
            "gps_lat" => [
                "nullable",
                "string",
                "max:15"
            ],
            "website_url" => [
                "nullable",
                "string",
                "max:200"
            ],
            //TO CHECK - Default value vs Nullable.
            "cost" => [
                "nullable",
                "string",
                "max:100000"
            ]
        ]);

        $location = new Location();
        $location->name = $validated["name"];
        $location->description_en = $validated["description_en"];
        $location->description_ja = $validated["description_ja"];
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $location_id, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "name" => [
                "required",
                "string",
                "max:255"
            ],
            "description_en" => [
                "nullable",
                "string",
                "max:2000"
            ],
            "description_ja" => [
                "nullable",
                "string",
                "max:2000"
            ],
            "gps_long" => [
                "nullable",
                "string",
                "max:15"
            ],
            "gps_lat" => [
                "nullable",
                "string",
                "max:15"
            ],
            "website_url" => [
                "nullable",
                "string",
                "max:200"
            ],
            //TO CHECK - Default value vs Nullable.
            "cost" => [
                "nullable",
                "string",
                "max:100000"
            ]
        ]);

        $location = Location::find($location_id);
        $location->name = $validated["name"];
        $location->description_en = $validated["description_en"];
        $location->description_ja = $validated["description_ja"];
        $location->gps_long = $validated["gps_long"];
        $location->gps_lat = $validated["gps_lat"];
        $location->website_url = $validated["website_url"];
        $location->cost = $validated["cost"];

        $location->save();

        //  TO CHECK - $location->user_id = auth()->user()->id;

        return redirect(route("location.show", $location->id))
            ->with("success", "Location updated successfully");
    }

    /**
     * Delete a specific location
     * todo
     *
     * @param int $location_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request, int $location_id): RedirectResponse
    {
        //TODO
        return redirect(route("location.index"))
            ->with('success', "Location deleted successfully");
    }
}

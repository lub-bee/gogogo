<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LocationController extends Controller
{
    function index() : View
    {
        //$locations = Location::all();
        $locations = Location::get();

        return view("admin.location.index")
            ->with("locations", $locations);

    }

    function show(int $location_id) : View
    {
        $location = Location::findOrFail($location_id);
        return view("admin/location/show")
           ->with("location", $location);

    }

    function create() : View
    {
        return view("admin.location.create");

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
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
            //TO CHECK - Default value vs Nullable.
            "cost" => [
                "nullable",
                //"string",
                //"max:1000"
            ]

        ]);

        $location = new Location();
        $location->name = $validated["name"];
        $location->description_en = $validated["description_en"];
        $location->description_ja = $validated["description_ja"];
        $location->cost = $validated["cost"];



        $location->user_id = auth()->user()->id;

        $location->save();
        return redirect()->route("location.show", $location->id);
        //return response()->redirect();

    }

    function edit($location_id) : View
    {
        $location = Location::where('id',$location_id)->firstOrFail();

        // $location = Location::find($location_id);
        //by author

        // $location = "location";

        // dd($location_id);
        return view("admin.location.edit")
            ->with('location_id', $location_id)
            ->with('location', $location);

    }

    function update($request,$location_id) : Response
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
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
            //TO CHECK - Default value vs Nullable.
            "cost" => [
                "nullable",
                "enum",
                "max:1000"
            ]

        ]);

        $location = Location::findOrFail($location_id);
        $location->name = $validated["name"];
        $location->description_en = $validated["description_en"];
        $location->description_ja = $validated["description_ja"];
        $location->cost = $validated["cost"];



        $location->user_id = auth()->user()->id;

        return response()->redirect();

    }

    function delete($request) : Response
    {

        return response()->redirect();

    }
}

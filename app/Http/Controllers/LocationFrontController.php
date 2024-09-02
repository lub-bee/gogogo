<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationFrontController extends Controller
{
    public function show(string $location_slug){
        $location = Location::where("slug", $location_slug)->firstOrFail();
        //display one specific location
        return view("front.location-show")
            ->with("location", $location);
    }
    //
}

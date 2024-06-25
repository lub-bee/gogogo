<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationFrontController extends Controller
{
    public function show(string $location_slug){
        //display one specific location
        return view("front.location-show");
    }
    //
}

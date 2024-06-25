<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaFrontController extends Controller
{
    public function show(Media $media){
        //display one specific media file
        return view("front.media-show");

    }
    //
}

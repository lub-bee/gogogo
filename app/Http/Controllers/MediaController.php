<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MediaController extends Controller
{
    function index() : View
    {
        //$medias = Media::all();
        $medias = Media::get();

        return view("admin.media.index")
            ->with("medias", $medias);

    }

    function show(int $media_id) : View
    {
        $media = Media::findOrFail($media_id);
        return view("admin/media/show")
           ->with("media", $media);

    }

    function create() : View
    {
        return view("admin.media.create");

    }

    function store($request) : Response
    {
        $validated = $request->validate([
            "name" => "required|string|max:60",
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

        ]);

        $media = new Media();
        $media->name = $validated["name"];
        $media->description_en = $validated["description_en"];
        $media->description_ja = $validated["description_ja"];



        $media->user_id = auth()->user()->id;



        return response()->redirect();

    }

    function edit($media_id) : View
    {
        $media = Media::where('id',$media_id)->firstOrFail();

        // $media = Media::find($media_id);
        //by author

        // $media = "media";

        // dd($media_id);
        return view("admin.media.edit")
            ->with('media_id', $media_id)
            ->with('media', $media);

    }

    function update($request) : Response
    {
        return response()->redirect();

    }

    function delete($request) : Response
    {

        return response()->redirect();

    }
}


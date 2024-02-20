<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TagController extends Controller
{
    function index() : View
    {
        //$tags = Tag::all();
        $tags = Tag::get();

        return view("admin.tag.index")
            ->with("tags", $tags);

    }

    function show(int $tag_id) : View
    {
        $tag = Tag::findOrFail($tag_id);
        return view("admin/tag/show")
           ->with("tag", $tag);

    }

    function create() : View
    {
        return view("admin.tag.create");

    }

    function store(Request $request) : Response
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

        $tag = new Tag();
        $tag->name = $validated["name"];
        $tag->description_en = $validated["description_en"];
        $tag->description_ja = $validated["description_ja"];



        $tag->user_id = auth()->user()->id;



        return response()->redirect();

    }

    function edit($tag_id) : View
    {
        $tag = Tag::where('id',$tag_id)->firstOrFail();

        // $tag = Topic::find($tag_id);
        //by author

        // $tag = "tag";

        // dd($tag_id);
        return view("admin.tag.edit")
            ->with('tag_id', $tag_id)
            ->with('tag', $tag);

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

<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TopicController extends Controller
{
    function index() : View
    {
        //$topics = Topic::all();
        $topics = Topic::get();

        return view("admin.topic.index")
            ->with("topics", $topics);

    }

    function show(int $topic_id) : View
    {
        $topic = Topic::findOrFail($topic_id);
        return view("admin/topic/show")
           ->with("topic", $topic);

    }

    function create() : View
    {
        return view("admin.topic.create");

    }

    function store(Request $request) : RedirectResponse
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

        $topic = new Topic();
        $topic->name = $validated["name"];
        $topic->description_en = $validated["description_en"];
        $topic->description_ja = $validated["description_ja"];

        $topic->user_id = auth()->user()->id;

        $topic->save();

        return redirect()->route("topic.index");

    }

    function edit($topic_id) : View
    {
        $topic = Topic::where('id',$topic_id)->firstOrFail();

        // $topic = Topic::find($topic_id);
        //by author

        // $topic = "topic";

        // dd($topic_id);
        return view("admin.topic.edit")
            ->with('topic_id', $topic_id)
            ->with('topic', $topic);

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

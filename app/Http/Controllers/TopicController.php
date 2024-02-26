<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TopicController extends Controller
{
    /**
     * Display topic list
     *
     * @return View
     */
    public function index() : View
    {
        $topics = Topic::orderBy("updated_at","desc")
            ->orderBy('name', 'asc')->get();

        return view("admin.topic.index")
            ->with("topics", $topics);
    }

    /**
     * Display one specifc topic detail
     *
     * @return View
     */
    public function show(int $topic_id) : View
    {
        $topic = Topic::findOrFail($topic_id);
        return view("admin/topic/show")
           ->with("topic", $topic);
    }

    /**
     * Display create form
     *
     * @return View
     */
    public function create() : View
    {
        return view("admin.topic.create");
    }

    /**
     * Store new topic instance
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => [
                "required",
                "string",
                "max:60"
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
        ]);

        $topic = new Topic();
        $topic->name = $validated["name"];
        $topic->description_en = $validated["description_en"];
        $topic->description_ja = $validated["description_ja"];
        $topic->user_id = auth()->user()->id;
        $topic->save();

        return redirect()->route("topic.index")
            ->with("success", "Topic saved successfully");
    }

    /**
     * Display edit form
     *
     * @param int $topic_id
     * @return View
     */
    public function edit(int $topic_id) : View
    {
        $topic = Topic::findOrFail($topic_id);
        return view("admin.topic.edit")
            ->with('topic', $topic);
    }

    /**
     * Update a specific Topic
     *
     * @param int $topic_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $topic_id , Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => [
                "required",
                "string",
                "max:60"
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
        ]);

        $topic =  Topic::find($topic_id);
        $topic->name = $validated["name"];
        $topic->description_en = $validated["description_en"];
        $topic->description_ja = $validated["description_ja"];

        $topic->save();

        return redirect(route("topic.show", $topic->id))
            ->with("success", "Topic saved successfully");
    }
    /**
     * Delete a specific topic
     * todo
     *
     * @param int $topic_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(int $topic_id, Request $request) : RedirectResponse
    {
        //todo
        return redirect(route("topic.index"))
        ->with('success','Event deleted successfully');
    }
}

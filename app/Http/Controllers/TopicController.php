<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\TopicDeleteRequest;
use App\Http\Requests\TopicPublishRequest;
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
     * @param TopicCreateRequest $request
     * @return RedirectResponse
     */
    public function store(TopicCreateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $topic = new Topic();
        $topic->name = $validated["name"];
        $topic->memo = $validated["memo"];
        $topic->description_en = $validated["description_en"];
        $topic->description_ja = $validated["description_ja"];

        if($validated["status"] == "published"){
            $topic->published_at = $validated["published_at"];
        }

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
     * @param TopicCreateRequest $request
     * @return RedirectResponse
     */
    public function update(int $topic_id , TopicCreateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $topic =  Topic::find($topic_id);
        $topic->name = $validated["name"];
        $topic->memo = $validated["memo"];
        $topic->description_en = $validated["description_en"];
        $topic->description_ja = $validated["description_ja"];

        // overwrite the published_at when unpublished
        if($validated["status"] == "published"){
            $topic->published_at = $validated["published_at"];
        } else {
            $topic->published_at = null;
        }

        $topic->save();

        return redirect(route("topic.show", $topic->id))
            ->with("success", "Topic saved successfully");
    }

    public function publish(Topic $topic, TopicPublishRequest $request) : RedirectResponse
    {
        $topic->published_at = now();
        $topic->save();
        return redirect(route("topic.show", $topic->id));
    }

    /**
     * Delete a specific topic
     *
     * @param TopicDeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(TopicDeleteRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $topic = Topic::findOrFail($validated['topic_id']);
        $topic->delete();

        return redirect(route("topic.index"))
            ->with('success',"Topic [$topic->name] deleted successfully");
    }
}

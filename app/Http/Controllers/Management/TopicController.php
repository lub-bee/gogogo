<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\StoreTopicRequest;
use App\Http\Requests\Management\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('events')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('management.topics.index', compact('topics'));
    }

    public function create()
    {
        $this->authorize('create', Topic::class);

        return view('management.topics.create');
    }

    public function store(StoreTopicRequest $request): RedirectResponse
    {
        $topic = new Topic($request->validated());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return redirect()->route('management.topics.index')
            ->with('status', "Topic \"{$topic->name}\" created.");
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);

        return view('management.topics.edit', compact('topic'));
    }

    public function update(UpdateTopicRequest $request, Topic $topic): RedirectResponse
    {
        $topic->fill($request->validated());
        $topic->save();

        return redirect()->route('management.topics.index')
            ->with('status', "Topic \"{$topic->name}\" updated.");
    }

    public function publish(Topic $topic): RedirectResponse
    {
        $this->authorize('update', $topic);

        $topic->publish();

        return back()->with('status', "Topic \"{$topic->name}\" published.");
    }

    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('delete', $topic);

        $name = $topic->name;
        $topic->delete();

        return redirect()->route('management.topics.index')
            ->with('status', "Topic \"{$name}\" deleted.");
    }
}

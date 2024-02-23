<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Display all tags as a list
     *
     * @return View
     */
    public function index() : View
    {
        $tags = Tag::orderBy("label","desc")
            ->orderBy("timestamp", "desc")->get();

        return view("admin.tag.index")
            ->with("tags", $tags);
    }

    /**
     * Display a specific tag
     *
     * @return View
     */
    public function show(int $tag_id) : View
    {
        $tag = Tag::findOrFail($tag_id);
        return view("admin/tag/show")
           ->with("tag", $tag);
    }

    /**
     * Display create tag form
     *
     * @return View
     */
    public function create() : View
    {
        return view("admin.tag.create");
    }

    /**
     * Store a new tag
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "label" => [
                "required",
                "string",
                "max:50",
            ],
            "slug" => [
                "required",
                "string",
                "max:50"
            ],
        ]);

        $tag = new Tag();
        $tag->label = $validated["label"];
        $tag->slug = $validated["slug"];

        $tag->user_id = auth()->user()->id;

        $tag->save();

        return redirect(route("tag.index"))
            ->with("success","Tag created successfully");
    }

    /**
     * Display a edit tag form
     *
     * @param int $tag_id
     * @return View
     */
    public function edit(int $tag_id) : View
    {
        $tag = Tag::findOrFail($tag_id);

        return view("admin.tag.edit")
            ->with('tag', $tag);
    }

    /**
     * Update a specific tag
     *
     * @param int $tag_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $tag_id, Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "label" => [
                "required",
                "string",
                "max:50",
            ],
            "slug" => [
                "required",
                "string",
                "max:50"
            ],
        ]);

        $tag = Tag::find($tag_id);
        $tag->label = $validated["label"];
        $tag->slug = $validated["slug"];

        $tag->save();

        return redirect(route("tag.show", $tag->id))
            ->with("success","Tag updated successfully");
    }

    /**
     * Delete a specific tag
     * todo
     *
     * @param int $tag_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(int $tag_id, Request $request) : RedirectResponse
    {
        //todo
        return redirect(route("tag.index"))
            ->with("success","Tag deleted successfully");

    }
}

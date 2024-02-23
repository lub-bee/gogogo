<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Display all Media as a list
     *
     * @return View
     */
    public function index() : View
    {
        $medias = Media::orderBy("timestamps", "desc")->get();
            //to check
            //->orderBy("","");
        return view("admin.media.index")
            ->with("medias", $medias);

    }

    /**
     * Display a specific piece of Media
     *
     * @return View
     */
    public function show(int $media_id) : View
    {
        $media = Media::findOrFail($media_id);
        return view("admin/media/show")
           ->with("media", $media);
    }

    /**
     * Display create form
     *
     * @return View
     */
    public function create() : View
    {
        return view("admin.media.create");
    }

    /**
     * Store a new Media file
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            //to check - Media migration table does not have a "name" for media
            //do I need to add one?
            "name" => [
                "required",
                "string",
                "max:60",
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

        $media = new Media();
        $media->name = $validated["name"];
        $media->description_en = $validated["description_en"];
        $media->description_ja = $validated["description_ja"];
        $media->user_id = auth()->user()->id;

        $media->save();


        return redirect(route("media.index"))
            ->with("success", "Media file saved successfully");
    }

    /**
     * Display edit form
     *
     * @param int $media_id
     * @return View
     */
    public function edit(int $media_id): View
    {
        $media = Media::findOrFail($media_id);
        return view("admin.media.edit")
            ->with('media', $media);
    }

    /**
     * Update a specific event
     *
     * @param int $media_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $media_id, Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            //to check - Media migration table does not have a "name" for media
            //do I need to add one?
            "name" => [
                "required",
                "string",
                "max:60",
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

        $media = Media::find($media_id);
        $media->name = $validated["name"];
        $media->description_en = $validated["description_en"];
        $media->description_ja = $validated["description_ja"];

        $media->save();

        return redirect(route("media.show", $media->id))
            ->with("success", "Media file updated successfully");
    }

    /**
     * Delete a specific Media file
     *
     * @param int $media_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(int $media_id, Request $request) : RedirectResponse
    {
        //todo - Need to check how to delete
        return redirect(route("media.index"))
            ->with("success", "Media file  deleted successfully");

    }
}


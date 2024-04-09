<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaCreateRequest;
use App\Http\Requests\MediaDeleteRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $medias = Media::orderBy("id", "asc")->get();
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
     * @param MediaCreateRequest $request
     * @return RedirectResponse
     */
    public function store(MediaCreateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $imageName = time().'.'.$request->picture->extension();
        $request->picture->move(public_path('pictures'), $imageName);
        $path = $imageName;

        $media = new Media();
        $media->path = $path;
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
     * @param MediaCreateRequest $request
     * @return RedirectResponse
     */
    public function update(MediaUpdateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $media = Media::findOrFail($validated["media_id"]);
        $media->description_en = $validated["description_en"];
        $media->description_ja = $validated["description_ja"];

        $media->save();

        return redirect(route("media.show", $media->id))
            ->with("success", "Media file updated successfully");
    }

    /**
     * Delete a specific Media file
     *
     * @param MediaDeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(MediaDeleteRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $media = Media::findOrFail($validated['media_id']);
        $media->delete();

        return redirect(route("media.index"))
            ->with("success", "Media [$media->name] deleted successfully");
    }
}


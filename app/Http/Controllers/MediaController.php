<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaCreateRequest;
use App\Http\Requests\MediaDeleteRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Http\Requests\MediaValidateRequest;
use App\Models\Event;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $valid_medias = Media::isValidated()->orderBy("id", "desc")->get();
        $pending_medias = Media::isNotValidated()->orderBy("id", "desc")->get();

        return view("admin.media.index")
            ->with("valid_medias", $valid_medias)
            ->with("pending_medias", $pending_medias);

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
        $events = Event::orderBy("start_at","desc")->get();

        return view("admin.media.create")
            ->with("events", $events);
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
        $path = Storage::putFileAs('public/pictures', $request->picture, $imageName);

        $media = new Media();
        $media->path = $path;
        $media->description_en = $validated["description_en"];
        $media->description_ja = $validated["description_ja"];
        $media->event_id = $validated["event_id"];
        $media->user_id = auth()->user()->id;

        if(auth()->user()->isAdmin()) {
            $media->validated_at = now();
        }

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
        $events = Event::orderBy("start_at","desc")->get();
        return view("admin.media.edit")
            ->with('media', $media)
            ->with('events', $events);
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

        // remove related file
        if (Storage::exists($media->path)) {
            Storage::delete($media->path);
        }

        //remove DB entry
        $media->delete();

        return redirect(route("media.index"))
            ->with("success", "Media deleted successfully");
    }

    public function updateValidatedAt(MediaValidateRequest $request) : RedirectResponse
    {
        $media = Media::findOrFail($request->validated()["media_id"]);
        $media->validated_at = now();
        $media->save();
        return redirect(route("media.index", $media->id));
    }
}


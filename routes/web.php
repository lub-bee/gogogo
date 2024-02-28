<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Models\Location;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Event
    Route::get('/event', [EventController::class, "index"])->name('event.index');
    Route::get('/event/create', [EventController::class, "create"])->name('event.create');
    Route::post('/event', [EventController::class, "store"])->name('event.store');
    Route::get('/event/{event_id}/edit', [EventController::class, "edit"])->name("event.edit");
    Route::get('/event/{event_id}', [EventController::class, "show"])->name('event.show');
    Route::put('/event/{event_id}',[EventController::class,"update"])->name('event.update');
    Route::delete('/event',[EventController::class,"destroy"])->name('event.destroy');

    //Topic
    Route::get('/topic',[TopicController::class, "index"])->name("topic.index");
    Route::get('/topic/create',[TopicController::class, "create"])->name("topic.create");
    Route::post('/topic', [TopicController::class, "store"])->name('topic.store');
    Route::get('/topic/{topic_id}/edit',[TopicController::class,"edit"])->name("topic.edit");
    Route::get('/topic/{topic_id}', [TopicController::class, "show"])->name('topic.show');
    Route::put('/topic/{topic_id}',[TopicController::class,"update"])->name('topic.update');
    Route::delete('/topic',[TopicController::class,"destroy"])->name('topic.destroy');


    //Location
    Route::get('/location',[LocationController::class, "index"])->name('location.index');
    Route::get('/location/create',[LocationController::class, "create"])->name('location.create');
    Route::post('/location', [LocationController::class, "store"])->name('location.store');
    Route::get('/location/{location_id}/edit',[LocationController::class,"edit"])->name('location.edit');
    Route::get('/location/{location_id}', [LocationController::class, "show"])->name('location.show');
    Route::put('/location/{location_id}',[LocationController::class,"update"])->name('location.update');
    Route::delete('/location',[LocationController::class,"destroy"])->name('location.destroy');


    //User
    Route::get('/user',[UserController::class, "index"])->name('user.index');
    Route::get('/user/create',[UserController::class, "create"])->name('user.create');
    Route::post('/user', [UserController::class, "store"])->name('user.store');
    Route::get('/user/{user_id}/edit',[UserController::class,"edit"])->name('user.edit');
    Route::get('/user/{user_id}', [UserController::class, "show"])->name('user.show');
    Route::put('/user/{user_id}',[UserController::class,"update"])->name('user.update');
    Route::delete('/user',[UserController::class,"destroy"])->name('user.destroy');


    //Media
    Route::get('/media',[MediaController::class, "index"])->name('media.index');
    Route::get('/media/create',[MediaController::class, "create"])->name('media.create');
    Route::post('/media', [MediaController::class, "store"])->name('media.store');
    Route::get('/media/{media_id}/edit',[MediaController::class,"edit"])->name('media.edit');
    Route::get('/media/{media_id}', [MediaController::class, "show"])->name('media.show');
    Route::put('/media/{media_id}',[MediaController::class,"update"])->name('media.update');
    Route::delete('/media',[MediaController::class,"destroy"])->name('media.destroy');

    //Tag
    Route::get('/tag',[TagController::class, "index"])->name('tag.index');
    Route::get('/tag/create',[TagController::class, "create"])->name('tag.create');
    Route::post('/tag', [TagController::class, "store"])->name('tag.store');
    Route::get('/tag/{tag_id}/edit',[TagController::class,"edit"])->name('tag.edit');
    Route::get('/tag/{tag_id}', [TagController::class, "show"])->name('tag.show');
    Route::put('/tag/{tag_id}',[TagController::class,"update"])->name('tag.update');
    Route::delete('/tag',[TagController::class,"destroy"])->name('tag.destroy');

});

require __DIR__.'/auth.php';

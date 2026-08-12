<?php

use App\Http\Controllers\Front\AgendaController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\LocationController;
use App\Http\Controllers\Front\MediaController;
use App\Http\Controllers\Front\TopController;
use App\Http\Controllers\Front\TopicController;
use App\Http\Controllers\Management\DashboardController;
use App\Http\Controllers\Management\EventController as ManagementEventController;
use App\Http\Controllers\Management\LocationController as ManagementLocationController;
use App\Http\Controllers\Management\MediaModerationController;
use App\Http\Controllers\Management\TopicController as ManagementTopicController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\MediaUploadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- Public front pages ---
Route::get('/', TopController::class)->name('top');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/event/{event:slug}', [EventController::class, 'show'])->name('event.show');
Route::get('/topics', [TopicController::class, 'index'])->name('topic.index');
Route::get('/topic/{topic:slug}', [TopicController::class, 'show'])->name('topic.show');
Route::get('/topic/{topic:slug}/download', [TopicController::class, 'download'])->name('topic.download');
Route::get('/locations', [LocationController::class, 'index'])->name('location.index');
Route::get('/location/{location:slug}', [LocationController::class, 'show'])->name('location.show');
Route::get('/media', [MediaController::class, 'index'])->name('media.index');

// --- RSVP (authenticated) ---
Route::post('/event/{event:slug}/rsvp', [EventController::class, 'rsvp'])
    ->middleware('auth')
    ->name('event.rsvp');

// --- Authenticated area ---
// Legacy Breeze dashboard redirect — now points to management dashboard
Route::get('/dashboard', function () {
    return redirect()->route('management.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Media upload (any authenticated user)
    Route::post('/media/upload', [MediaUploadController::class, 'store'])->name('media.upload');
});

// --- Management area (admin / support) ---
Route::prefix('management')->middleware(['auth', 'rank:admin,support'])->group(function () {
    // Dashboard
    Route::get('/', DashboardController::class)->name('management.dashboard');

    // Events CRUD (bind by id — slug binding is for public front)
    Route::get('/events', [ManagementEventController::class, 'index'])->name('management.events.index');
    Route::get('/events/create', [ManagementEventController::class, 'create'])->name('management.events.create');
    Route::post('/events', [ManagementEventController::class, 'store'])->name('management.events.store');
    Route::get('/events/{event:id}/edit', [ManagementEventController::class, 'edit'])->name('management.events.edit');
    Route::put('/events/{event:id}', [ManagementEventController::class, 'update'])->name('management.events.update');
    Route::post('/events/{event:id}/publish', [ManagementEventController::class, 'publish'])->name('management.events.publish');
    Route::post('/events/{event:id}/unpublish', [ManagementEventController::class, 'unpublish'])->name('management.events.unpublish');
    Route::delete('/events/{event:id}', [ManagementEventController::class, 'destroy'])->name('management.events.destroy');

    // Topics CRUD (bind by id)
    Route::get('/topics', [ManagementTopicController::class, 'index'])->name('management.topics.index');
    Route::get('/topics/create', [ManagementTopicController::class, 'create'])->name('management.topics.create');
    Route::post('/topics', [ManagementTopicController::class, 'store'])->name('management.topics.store');
    Route::get('/topics/{topic:id}/edit', [ManagementTopicController::class, 'edit'])->name('management.topics.edit');
    Route::put('/topics/{topic:id}', [ManagementTopicController::class, 'update'])->name('management.topics.update');
    Route::post('/topics/{topic:id}/publish', [ManagementTopicController::class, 'publish'])->name('management.topics.publish');
    Route::delete('/topics/{topic:id}', [ManagementTopicController::class, 'destroy'])->name('management.topics.destroy');

    // Locations CRUD (bind by id)
    Route::get('/locations', [ManagementLocationController::class, 'index'])->name('management.locations.index');
    Route::get('/locations/create', [ManagementLocationController::class, 'create'])->name('management.locations.create');
    Route::post('/locations', [ManagementLocationController::class, 'store'])->name('management.locations.store');
    Route::get('/locations/{location:id}/edit', [ManagementLocationController::class, 'edit'])->name('management.locations.edit');
    Route::put('/locations/{location:id}', [ManagementLocationController::class, 'update'])->name('management.locations.update');
    Route::delete('/locations/{location:id}', [ManagementLocationController::class, 'destroy'])->name('management.locations.destroy');

    // Media moderation
    Route::get('/media', [MediaModerationController::class, 'index'])->name('management.media');
    Route::post('/media/{media}/approve', [MediaModerationController::class, 'approve'])->name('management.media.approve');
    Route::post('/media/{media}/refuse', [MediaModerationController::class, 'refuse'])->name('management.media.refuse');
    Route::post('/media/{media}/re-refuse', [MediaModerationController::class, 'reRefuse'])->name('management.media.re-refuse');
    Route::delete('/media/{media}', [MediaModerationController::class, 'destroy'])->name('management.media.destroy');
    Route::post('/media/bulk', [MediaModerationController::class, 'bulk'])->name('management.media.bulk');

    // User management (admin only)
    Route::middleware('rank:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('management.users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('management.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('management.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('management.users.destroy');
    });
});

require __DIR__.'/auth.php';

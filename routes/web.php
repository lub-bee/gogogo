<?php

use App\Http\Controllers\Front\AgendaController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\LocationController;
use App\Http\Controllers\Front\MediaController;
use App\Http\Controllers\Front\TopController;
use App\Http\Controllers\Front\TopicController;
use App\Http\Controllers\Management\MediaModerationController;
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
Route::get('/dashboard', function () {
    return view('dashboard');
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
    Route::get('/media', [MediaModerationController::class, 'index'])->name('management.media');
    Route::post('/media/{media}/approve', [MediaModerationController::class, 'approve'])->name('management.media.approve');
    Route::post('/media/{media}/refuse', [MediaModerationController::class, 'refuse'])->name('management.media.refuse');
    Route::post('/media/bulk', [MediaModerationController::class, 'bulk'])->name('management.media.bulk');
});

require __DIR__.'/auth.php';

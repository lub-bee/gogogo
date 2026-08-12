<?php

use App\Http\Controllers\Front\AgendaController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\LocationController;
use App\Http\Controllers\Front\MediaController;
use App\Http\Controllers\Front\TopController;
use App\Http\Controllers\Front\TopicController;
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
});

require __DIR__.'/auth.php';

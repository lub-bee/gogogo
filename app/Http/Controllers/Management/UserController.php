<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::withCount('media')
            ->orderBy('name')
            ->paginate(20);

        return view('management.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('management.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // An admin cannot demote themselves
        if ($request->user()->id === $user->id && $request->input('rank') !== $user->rank) {
            return back()->with('error', 'You cannot change your own rank.');
        }

        $validated = $request->validate([
            'rank' => ['required', Rule::in(User::RANKS)],
        ]);

        $user->update($validated);

        return redirect()->route('management.users.index')
            ->with('status', "User \"{$user->name}\" rank updated to {$user->rank}.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        // Policy already prevents self-delete, but belt-and-suspenders
        if ($request->user()->id === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('management.users.index')
            ->with('status', "User \"{$name}\" deleted.");
    }
}

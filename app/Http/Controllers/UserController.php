<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User as ModelsUser;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display user list
     *
     * @return View
     */
    public function index() : View
    {
        $users = User::orderBy("name", "desc")
            ->orderBy('email_verified_at', 'asc')->get();

        return view("admin.user.index")
        ->with("users", $users);
    }

    /**
     * Display one specific user
     *
     * @return View
     */
    public function show(int $user_id) : View
    {
        $user = User::findOrFail($user_id);
        return view("admin/user/show")
           ->with("user", $user);
    }

    /**
     * Display create form
     *
     * @return View
     */
    public function create() : View
    {
        return view("admin.user.create");
    }

    /**
     * Store new user instance
     *
     * @param UserCreateRequest $request
     * @return RedirectResponse
     */
    public function store(UserCreateRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

            // "email" => [
            //     "required",
            //     "string",
            //     "max:100"
            // ],
        //]);

        $user = new User();
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->rank = $validated["rank"];
        $user->password = Hash::make($validated["password"]);
        /**
         *
         * to check
         * how to integrate password/ verified login details whilst still hashed and protected for privacy
         * guessing I need to read upon tokens
         */

        $user->save();

        //TODO add email job to the queue with the password in it;

        return redirect()->route("user.index")
            ->with("success", "User saved successfully");
    }

    /**
     * Display user edit form
     *
     * @param int $user_id
     * @return View
     */
    public function edit(int $user_id) : View
    {
        $user = User::findOrFail($user_id);
        return view("admin.user.edit")
            ->with('user', $user);

    }

    /**
     * Update a specific user
     *
     * @param int $user_id
     * @param UserCreateRequest $request
     * @return RedirectResponse
     */
    public function update(int $user_id, UserUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::find($user_id);
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->rank = $validated["rank"];

        //only save when data have actually changed
        if($user->isDirty()) {
            $user->save();
        }

        return redirect(route("user.show", $user->id))
            ->with("success","User updated successfully");

    }
    /**
     * Delete a specific user
     *
     * @param UserDeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(UserDeleteRequest $request) : RedirectResponse
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['$user_id']);
        $user->delete();

        return redirect(route("user.index"))
            ->with("success", "User [$user->name] deleted successfully");

    }
}


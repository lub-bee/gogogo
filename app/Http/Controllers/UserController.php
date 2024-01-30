<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    function index() : View
    {

        $users = ModelsUser::get();

        return view("admin.user.index")
            ->with("users", $users);

    }

    function show(int $user_id) : View
    {
        $user = User::findOrFail($user_id);
        return view("admin/user/show")
           ->with("user", $user);

    }

    function create() : View
    {
        return view("admin.user.create");

    }

    function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:60",
            "email" => ["required","string","max:100"],
        ]);

        $user = new User();
        $user->name = $validated["name"];
        $user->email = $validated["email"];

        $password = "abcd";//generateRandPassword()

        $user->password = Hash::make($password);
        $user->save();

        //TODO add email job to the queue with the password in it;

        return redirect()->route("user.index");

    }

    function edit($user_id) : View
    {
        $user = ModelsUser::where('id',$user_id)->firstOrFail();

        // $user = User::find($user_id);

        // $user = "user";

        // dd($user_id);
        return view("admin.user.edit")
            ->with('user_id', $user_id)
            ->with('user', $user);

    }

    function update(Request $request) : RedirectResponse
    {
        return redirect()->route("user.index");

    }

    function delete(Request $request) : RedirectResponse
    {

        return redirect()->route("user.index");

    }
}


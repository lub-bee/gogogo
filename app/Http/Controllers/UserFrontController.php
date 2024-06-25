<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserFrontController extends Controller
{
    public function show(User $user) {
        //display one specific user
        return view("front.user-show");

    }
    //
}

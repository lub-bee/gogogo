<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicFrontController extends Controller
{
    public function index(){
        //display 5 latest topics
        return view("front.topic-index");
    }

    public function show (string $topic_slug){
        //display a specific topic
        return view("front.topic-show");


    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicFrontController extends Controller
{
    public function show (string $topic_slug){
        $topic = Topic::where("slug", $topic_slug)->firstOrFail();

        //display a specific topic
        return view("front.topic-show")
            ->with("topic", $topic);


    }
}

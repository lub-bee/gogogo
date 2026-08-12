<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::published()
            ->orderByDesc('published_at')
            ->paginate(20);

        return view('front.topic-index', [
            'topics' => $topics,
        ]);
    }

    public function show(Request $request, Topic $topic)
    {
        $user = $request->user();
        if (! $topic->isPublished()) {
            if (! $user || ! $user->hasRank('admin', 'support')) {
                abort(404);
            }
        }

        return view('front.topic-show', [
            'topic' => $topic,
        ]);
    }

    public function download(Request $request, Topic $topic)
    {
        $user = $request->user();
        if (! $topic->isPublished()) {
            if (! $user || ! $user->hasRank('admin', 'support')) {
                abort(404);
            }
        }

        $filename = $topic->slug . '.txt';

        $content = $topic->name . "\n";
        $content .= str_repeat('=', mb_strlen($topic->name)) . "\n\n";

        if ($topic->description_en) {
            $content .= "--- English ---\n\n";
            $content .= strip_tags($topic->description_en) . "\n\n";
        }

        if ($topic->description_ja) {
            $content .= "--- 日本語 ---\n\n";
            $content .= strip_tags($topic->description_ja) . "\n\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}

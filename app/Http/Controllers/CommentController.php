<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\CommentPosted;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = new Comment([
            'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
            'post_id' => $postId,
            'content' => $validated['content'],
        ]);

        $comment->save();

        // Fire the CommentPosted event
        broadcast(new CommentPosted($comment));

        // Return data for Inertia.js
        return Inertia::render('Post/Show', [
            'post' => $comment->post,
            'comments' => $comment->post->comments,
        ]);
    }
}
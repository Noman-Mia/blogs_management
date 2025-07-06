<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['body' => 'required']);

        Comment::create([
            'body' => $request->body,
            'user_id' => session('LoggedUser'), // use auth()->id() if applicable
            'post_id' => $post->id,
            'parent_id' => $request->parent_id // null for top-level
        ]);

        return back()->with('success', 'Comment added');
    }

    public function destroy(Comment $comment)
    {
        $userId = session('LoggedUser'); // use auth()->id() if applicable
        if ($comment->post->user_id === $userId || $comment->user_id === $userId) {
            $comment->delete();
        }

        return back()->with('success', 'Comment deleted');
    }
}

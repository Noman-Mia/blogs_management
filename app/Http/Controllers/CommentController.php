<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Events\CommentPosted;
use Inertia\Inertia;
use App\Models\User;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        $comment->load('user');

        broadcast(new CommentPosted($comment))->toOthers();

       return inertia()->location('blogs');
    }

    public function destroy(Comment $comment)
    {
        $email = session()->get('email');
        $user = User::where('email', $email)->first();

        if ($user && $comment->post->user_id === $user->id) {
            $comment->delete();
            return response()->noContent();
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function edit(Comment $comment)
    {
        $email = session()->get('email');
        $user = User::where('email', $email)->first();

        if ($user && $comment->post->user_id === $user->id) {
            return Inertia::render('EditComment', [
                'comment' => $comment,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
 public function show(Comment $comment)
    {
        $email = session()->get('email');
        $user = User::where('email', $email)->first();

        if ($user && $comment->post->user_id === $user->id) {
            return Inertia::render('ShowComment', [
                'comment' => $comment,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}

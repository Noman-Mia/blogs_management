<?php
// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, $postId)
    {
        $user = Auth::user();
        $user = $request->user();

        // Check if the user already liked the post
        $like = Like::where('post_id', $postId)
                    ->where('user_id', $user->id)
                    ->first();

        if ($like) {
            // User already liked the post, so we remove the like
            $like->delete();
        } else {
            // User hasn't liked the post yet, so we add a like
            Like::create([
                'post_id' => $postId,
                'user_id' => $user->id,
            ]);
        }

        // Reload the updated post with the like count
        $updatedPost = Post::withCount('likes')->findOrFail($postId);

        // Return the updated post data
        return Inertia::render('Blogs', [
            'posts' => Post::with('likes')->get(), // Send all posts with likes
            'updatedPost' => $updatedPost, // Send the updated post
        ]);
    }
}

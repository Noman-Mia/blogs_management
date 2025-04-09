<?php
// app/Http/Controllers/LikeController.php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $email = session()->get('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the user has already liked the post
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Already liked'], 400);
        }

        // Create a new like
        $post->likes()->create([
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Liked successfully']);
    }

    public function unlike(Post $post)
    {
        $email = session()->get('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the user has liked the post
        $like = $post->likes()->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json(['error' => 'Not liked yet'], 400);
        }

        // Delete the like
        $like->delete();

        return response()->json(['message' => 'Unliked successfully']);
    }
    public function getLikes(Post $post)
    {
        $likes = $post->likes()->with('user')->get();

        return response()->json($likes);
    }
    
}

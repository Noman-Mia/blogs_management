<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $postId = $request->post_id;

        $bookmark = Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        return response()->json(['message' => 'Bookmarked successfully']);
    }

    public function index()
    {
        $bookmarks = Bookmark::with('post')->where('user_id', Auth::id())->get();

        return inertia('Bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }
}

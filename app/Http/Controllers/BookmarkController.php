<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarkController extends Controller
{
 

   // In your BookmarkController.php
public function index()
{
    // Fetch bookmarks for the authenticated user (assuming you're using user authentication)
    $bookmarks = Bookmark::where('user_id', Auth::id())->with('post')->get();

    // Pass bookmarks to the Inertia page
    return Inertia::render('Bookmarks', [
        'bookmarks' => $bookmarks
    ]);
}
public function store(Request $request)
{
    // Create a bookmark for the authenticated user
    $bookmark = new Bookmark();
    $bookmark->user_id = Auth::id();  // Assuming you're using user authentication
    $bookmark->post_id = $request->post_id;
    $bookmark->save();

    // Optionally, return the bookmark as a response
    return response()->json([
        'bookmark' => $bookmark
    ]);
}


}

<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    // // Show all bookmarks of the logged-in user
    // public function index()
    // {
    //     $bookmarks = Bookmark::where('user_id', Auth::id())
    //         ->with('post') 
    //         ->get();

    //     return Inertia::render('Bookmarks', [
    //         'bookmarks' => $bookmarks
    //     ]);
    // }

    // Add a post to bookmark
    public function store(Request $request)
{
    $request->validate([
        'post_id' => 'required|exists:posts,id',
    ]);

    // Get user_id from session
    $user_id = session('user_id');
    
    // Check if the bookmark already exists
    $existing = Bookmark::where('user_id', $user_id)
        ->where('post_id', $request->post_id)
        ->first();

    if ($existing) {
        // If already bookmarked, return the current page with a flash message
        return redirect()->back()->with('message', 'Bookmarked already!');
    }

    // Create the new bookmark if not already present
    $bookmark = Bookmark::create([
        'user_id' => $user_id,
        'post_id' => $request->post_id,
    ]);

    // Return the current page with a success message
    return redirect()->back()->with('message', 'Bookmark added successfully!');
}
    public function index()
    {
        $user_id = session('user_id');
        $bookmarks = Bookmark::where('user_id', $user_id)
            ->with('post') 
            ->get();

        return Inertia::render('Bookmarks', [
            'bookmarks' => $bookmarks
        ]);
    }
    // Remove a bookmark
    public function destroy($id)
    {
        $user_id = session('user_id');
        $bookmark = Bookmark::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        $bookmark->delete();

        return redirect()->back()->with('message', 'Bookmark removed successfully!');
    }
    // public function destroy($id)
    // {
    //     $bookmark = Bookmark::where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();

    //     $bookmark->delete();

    //     return response()->json([
    //         'message' => 'Bookmark deleted successfully'
    //     ]);
    // }
}

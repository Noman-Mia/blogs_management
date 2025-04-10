<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarkController extends Controller
{
  
    public function store(Request $request)
{
    $request->validate([
        'post_id' => 'required|exists:posts,id',
    ]);

    $user_id = session('user_id');
    
    $existing = Bookmark::where('user_id', $user_id)
        ->where('post_id', $request->post_id)
        ->first();

    if ($existing) {
        return redirect()->back()->with('message', 'Bookmarked already!');
    }

    $bookmark = Bookmark::create([
        'user_id' => $user_id,
        'post_id' => $request->post_id,
    ]);

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
   
}

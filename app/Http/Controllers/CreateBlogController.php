<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CreateBlogController extends Controller
{
    public function store(Request $request)
    {
        $user_id = $request->header('id');
    
        if (!$user_id) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:public,private',
            'image' => 'nullable|image|max:2048',
        ]);
    
        $validated['user_id'] = $user_id;
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }
    
        Post::create($validated);
    
        return redirect()->route('CreateBlog')->with('success', 'Blog created successfully!');
    }
 

    //Delete
    public function delete( $id)
{
   
    $post = Post::find($id);
    
    if (!$post) {
        return redirect()->back()->with('error', 'Post not found.');
    }
    if ($post->image) {
        $imagePath = 'public/blogs/' . $post->image; 
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath); 
        }
    }

    $post->delete();

    return redirect()->route('CreateBlog')->with('success', 'Post deleted successfully!');
}

    
}
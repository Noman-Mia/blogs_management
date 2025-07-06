<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('visibility', 'public')
            ->with('user:id,name')
            ->orderBy('id', 'desc')
            ->simplePaginate(3);

        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'visibility' => 'required|in:public,private',
            'tags' => 'nullable|string'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->visibility = $request->input('visibility');

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imageName = time() . '.' . $img->getClientOriginalExtension();
            $imgPath = 'uploads/' . $imageName;
            $img->move(public_path('uploads'), $imageName);
            $post->img = $imgPath;
        }

        $post->user_id = session('LoggedUser');
        $post->save();

        if ($request->filled('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $name) {
                $name = trim($name);
                if (!empty($name)) {
                    $tag = Tag::firstOrCreate(['name' => $name]);
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('user.dashboard')->with('success', 'Post Created Successfully');
    }

    public function edit($id)
    {
        $post = Post::find($id);

        if (!$post || session('LoggedUser') !== $post->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized or post not found.');
        }

        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:public,private',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $post = Post::find($id);

        if (!$post || session('LoggedUser') !== $post->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized or post not found.');
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->visibility = $request->visibility;

        if ($request->hasFile('img')) {
            if ($post->img && file_exists(public_path($post->img))) {
                unlink(public_path($post->img));
            }

            $img = $request->file('img');
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;
            $img->move(public_path('uploads'), $fileName);
            $post->img = $filePath;
        }

        $post->save();

        return redirect()->route('user.dashboard')->with('success', 'Post Updated Successfully');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post || session('LoggedUser') !== $post->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized or post not found.');
        }

        $post->delete();

        return redirect()->route('user.dashboard')->with('success', 'Post deleted successfully.');
    }
}

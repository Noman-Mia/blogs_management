<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('LoginPage');
    }
    public function CreateBlog()
    {
        return Inertia::render('CreateBlog');
    }
    public function ShowBlogs()
    {
        // Fetch all posts
        $posts = Post::all(); 

        return Inertia::render('Blogs', [
            'posts' => $posts, 
        ]);
    }

}

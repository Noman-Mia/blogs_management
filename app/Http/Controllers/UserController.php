<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class UserController extends Controller
{
    public function login()
    {
        return Inertia::render('user/Login');
    }

    public function register()
    {
        return Inertia::render('user/Register');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|max:12|min:3|confirmed',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imageName = time() . '.' . $img->getClientOriginalExtension();
            $imgPath = 'uploads/' . $imageName;
            $img->move(public_path('uploads'), $imageName);
            $user->img = $imgPath;
        }

        $user->save();

        return redirect()->route('user.login')->with('success', 'User Created Successfully, Please Login');
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:12|min:3',
        ]);

        $userInfo = User::where('email', $request->email)->first();

        if (!$userInfo) {
            return back()->with('fail', "We don't recognize your email address");
        }

        if ($request->password === $userInfo->password) {
            $request->session()->put('LoggedUser', $userInfo->id);
            return redirect()->route('user.dashboard.all');
        } else {
            return back()->with('fail', 'Password is incorrect');
        }
    }

    public function dashboard()
    {
        $LoggedUser = User::with(['posts' => function ($query) {
            $query->orderBy('id', 'desc');
        }])->find(session('LoggedUser'));

        if (!$LoggedUser) {
            return redirect()->route('user.login')->with('fail', 'Please login first.');
        }

        return Inertia::render('user/Dashboard', [
            'LoggedUser' => $LoggedUser
        ]);
    }

    public function dashboardAll(Request $request)
    {
        $query = Post::with(['user:id,name', 'likes'])->where('visibility', 'public');

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $posts = $query->orderBy('id', 'desc')->simplePaginate(3);
        $LoggedUser = User::find(session('LoggedUser'));

        return Inertia::render('user/Home', [
            'posts' => $posts,
            'LoggedUser' => $LoggedUser,
            'search' => $request->input('search')
        ]);
    }

    public function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
        }

        return redirect()->route('user.login');
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreateBlogController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\SessionAuthenticate;




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('home');

Route::post('/CreateBlog', [CreateBlogController::class, 'store']); 
Route::get('/ShowBlogs', [HomeController::class, 'ShowBlogs'])->name('ShowBlogs'); // Form
Route::get('/blogs', [CreateBlogController::class, 'index'])->name('blogs.index');


Route::delete('/delete/{id}', [CreateBlogController::class, 'delete'])
->name('posts.destroy');


//User all routes
Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');
Route::post('/send-otp', [UserController::class, 'SendOTPCode'])->name('SendOTPCode');
Route::post('/verify-otp', [UserController::class, 'VerifyOTP'])->name('VerifyOTP');



Route::middleware(SessionAuthenticate::class)->group(function(){
    //reset password
    Route::post('/reset-password', [UserController::class, 'ResetPassword']);

    Route::get('/DashboardPage', [UserController::class, 'DashboardPage']);
    Route::get('/user-logout', [UserController::class, 'UserLogout']);

    //
    Route::get('/CreateBlog', [HomeController::class, 'CreateBlog'])->name('CreateBlog'); // Form
    Route::post('/CreateBlog', [CreateBlogController::class, 'store']); // Form submit
    Route::get('/blogs', [HomeController::class, 'ShowBlogs'])->name('blogs.index');
   
    
    //Resetpassword page
    Route::get('/reset-password',[UserController::class, 'ResetPasswordPage']);

    Route::get('/ProfilePage', [UserController::class, 'ProfilePage']);
    Route::get('/user-from', [UserController::class, 'UserFrom']);
    Route::post('/user-update', [UserController::class, 'UserUpdate']);

Route::get('/edit/{id}', [CreateBlogController::class, 'edit'])->name('edit.blog');
Route::put('/update/{id}', [CreateBlogController::class, 'update'])->name('update.blog');

//Bookmark all routes
Route::post('/bookmarks', [BookmarkController::class, 'store']);
Route::delete('/bookmarks/{post}', [BookmarkController::class, 'destroy']);
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks');



// Store a new comment for a post
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
//like and unlike
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');

});

//Pages all routes
Route::get('/login',[UserController::class, 'LoginPage'])->name('login.page');
Route::get('/registration',[UserController::class, 'RegistrationPage'])->name('registration.page');
Route::get('/send-otp',[UserController::class, 'SendOTPPage'])->name('sendotp.page');
Route::get('/verify-otp',[UserController::class, 'VerifyOTPPage'])->name('VerifyOTPPage');




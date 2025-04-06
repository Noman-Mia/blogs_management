<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CreateBlogController;
use App\Http\Controllers\BookmarkController;
use App\Http\Middleware\SessionAuthenticate;




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'ProfilePage'])->name('home');

Route::post('/CreateBlog', [CreateBlogController::class, 'store']); // Form submit
Route::get('/ShowBlogs', [HomeController::class, 'ShowBlogs'])->name('ShowBlogs'); // Form
Route::get('/blogs', [CreateBlogController::class, 'index'])->name('blogs.index');

Route::put('/posts/{id}', [CreateBlogController::class, 'update']);


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
   
    // //Profile all routes
    // Route::post('/create-customer', [CustomerController::class, 'CreateCustomer'])->name('CreateCustomer');
    // Route::get('/list-customer', [CustomerController::class, 'CustomerList'])->name('CustomerList');
    // Route::post('/customer-by-id', [CustomerController::class, 'CustomerById'])->name('CustomerById');
    // Route::post('/update-customer', [CustomerController::class, 'CustomerUpdate'])->name('CustomerUpdate');
    // Route::get('/delete-customer/{id}', [CustomerController::class, 'CustomerDelete'])->name('CustomerDelete');
    // Route::get('/CustomerPage', [CustomerController::class, 'CustomerPage'])->name('CustomerPage');
    // Route::get('/CustomerSavePage', [CustomerController::class, 'CustomerSavePage'])->name('CustomerSavePage');

    //Resetpassword page
    Route::get('/reset-password',[UserController::class, 'ResetPasswordPage']);

    Route::get('/ProfilePage', [UserController::class, 'ProfilePage']);
    Route::get('/user-from', [UserController::class, 'UserFrom']);
    Route::post('/user-update', [UserController::class, 'UserUpdate']);

    // Route::post('/bookmarks', [BookmarkController::class, 'store']);
    // Route::get('/bookmarks', [BookmarkController::class, 'index']);
});

//Pages all routes
Route::get('/login',[UserController::class, 'LoginPage'])->name('login.page');
Route::get('/registration',[UserController::class, 'RegistrationPage'])->name('registration.page');
Route::get('/send-otp',[UserController::class, 'SendOTPPage'])->name('sendotp.page');
Route::get('/verify-otp',[UserController::class, 'VerifyOTPPage'])->name('VerifyOTPPage');




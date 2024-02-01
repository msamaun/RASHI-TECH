<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



//View routes
Route::view('/', 'admin.pages.home.home')->name('home');
Route::view('/login', 'admin.components.auth.login')->name('login');
Route::view('/register', 'admin.components.auth.registration')->name('register');
Route::view('/profile', 'admin.components.auth.profile')->name('user_profile');
Route::view('/dashboard', 'admin.components.dashboard.dashboard')->name('dashboard');
Route::view('/post', 'admin.pages.post.post')->name('post');

//Auth routes
Route::post('/user_registration', [UserController::class, 'register']);
Route::post('/user_login', [UserController::class, 'login'])->name('user_login');
Route::get('/user_profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::post('/user_update_profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

//Post routes
Route::post('/create_post', [PostController::class, 'createPost'])->middleware('auth:sanctum');
Route::post('/update_post', [PostController::class, 'updatePost'])->middleware('auth:sanctum');
Route::post('/delete_post', [PostController::class, 'deletePost'])->middleware('auth:sanctum');
Route::post('/post-by-id', [PostController::class, 'getPostById'])->middleware('auth:sanctum');
Route::get('/posts_list', [PostController::class, 'postList'])->middleware('auth:sanctum');


Route::get('/dashboard_list', [DashboardController::class, 'dashboardList'])->middleware('auth:sanctum');

Route::get('/PostGet', [HomeController::class, 'home']);
Route::get('/singlePost/{id}', [HomeController::class, 'singlePost']);

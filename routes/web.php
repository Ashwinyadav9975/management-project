<?php
use App\Http\Controllers\Edit_user;
use App\Http\Controllers\Home;
use App\Http\Controllers\Show_dashboard;
use App\Http\Controllers\Edit_profile;
use App\Http\Controllers\register;
use App\Http\Controllers\login;
use App\Http\Controllers\Welcome_controller;
use Illuminate\Support\Facades\Route;

// Default welcome route
Route::get('/', function () {
    return view('welcome');
});
// Registration Routes
Route::get('/register', [register::class, 'show_registration_form'])->name('register');
Route::post('/register', [register::class, 'register_user'])->name('register.post');

// Login Routes
Route::get('/login', [login::class, 'Show_login_form'])->name('login');
Route::post('/login_user', [login::class, 'login_user'])->name('login_user.post');

// Dashboard route (protected)
Route::post('/logout', [login::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('home', [Home::class, 'Home_data'])->name('home');
    Route::get('/fetch-users', [Home::class, 'fetch_users'])->name('users.fetch');
    Route::delete('/user/{id}', [Home::class, 'Delete_user'])->name('user.delete');
    
    // Edit User Routes
    Route::get('user/edit/{id}', [Edit_user::class, 'edit'])->name('edit_user');
    Route::put('user.update/{id}', [Edit_user::class, 'update_user'])->name('user.update');

    // Edit Profile Routes
    Route::get('userprofile/edit/{id}', [Edit_profile::class, 'Edit_profile'])->name('edit_profile');
    Route::put('userprofile.update/{id}', [Edit_profile::class, 'update'])->name('userprofile.update');

    
});
use App\Http\Controllers\LogController; // Ensure you have the correct controller imported

Route::post('/store-log', [LogController::class, 'storeLog']);


Route::get('/dashboard', [Show_dashboard::class, 'Dashboard'])->name('dashboard'); // For the view
Route::get('/home-data', [Show_dashboard::class, 'home_user'])->name('home_data'); // For AJAX data loading

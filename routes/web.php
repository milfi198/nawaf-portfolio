<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PhotoController;
use App\Models\Photo;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', function () {
    return view('home');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/my-photography', function (Request $request) {
    $selectedCategory = $request->query('category', 'All');

    $categories = Photo::query()
        ->whereNotNull('category')
        ->where('category', '!=', '')
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    $photos = Photo::withCount(['likes', 'comments'])
        ->when($selectedCategory !== 'All', function ($query) use ($selectedCategory) {
            $query->where('category', $selectedCategory);
        })
        ->latest()
        ->get();

    return view('photography.index', compact('photos', 'categories', 'selectedCategory'));
});

Route::get('/my-photography/{photo}', function (Photo $photo) {
    return view('photography.show', compact('photo'));
});

Route::get('/login', function () {
    return redirect('/my-photography')->withErrors([
        'login' => 'Please login first.'
    ]);
});

Route::get('/register', function () {
    return redirect('/my-photography');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/users', [DashboardController::class, 'users']);
    Route::get('/admin/comments', [DashboardController::class, 'comments']);
    Route::delete('/admin/comments/{comment}', [DashboardController::class, 'destroyComment'])->name('admin.comments.destroy');
    Route::get('/admin/settings', [DashboardController::class, 'settings']);
    Route::post('/admin/settings', [DashboardController::class, 'updateSettings'])->name('admin.settings.update');

    Route::delete('/admin/users/{user}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::get('/admin/settings', [DashboardController::class, 'settings']);
    Route::post('/admin/settings', [DashboardController::class, 'updateSettings'])->name('admin.settings.update');

    Route::get('/admin/photos', [PhotoController::class, 'index']);
    Route::get('/admin/photos/create', [PhotoController::class, 'create']);
    Route::post('/admin/photos', [PhotoController::class, 'store']);
    Route::delete('/admin/photos/{photo}', [PhotoController::class, 'destroy']);
});


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

Route::post('/my-photography/{photo}/like', [LikeController::class, 'toggle'])->name('photos.like');
Route::post('/my-photography/{photo}/comments', [CommentController::class, 'store'])->name('photos.comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

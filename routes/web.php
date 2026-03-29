<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CommentController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/berita', [FrontendController::class, 'posts'])->name('posts');
Route::get('/berita/kategori/{category:slug}', [FrontendController::class, 'posts'])->name('posts.category');
Route::get('/berita/{slug}', [FrontendController::class, 'postDetail'])->name('posts.show');
Route::get('/guru-staff', [FrontendController::class, 'teachers'])->name('teachers');
Route::get('/guru', [FrontendController::class, 'teachers'])->name('guru');
Route::get('/prestasi', [FrontendController::class, 'achievements'])->name('achievements');
Route::get('/ekstrakurikuler', [FrontendController::class, 'extracurriculars'])->name('extracurriculars');
Route::get('/galeri', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [FrontendController::class, 'guestbook'])->name('kontak');
Route::get('/guest-book', [FrontendController::class, 'guestbook'])->name('guestbook');
Route::post('/guest-book', [FrontendController::class, 'guestbookSubmit'])->name('guestbook.submit');

// Profil Routes
Route::get('/profil/sejarah', function() {
    $menuItems = \App\Models\Menu::where('is_active', true)
        ->whereNull('parent_id')
        ->with('children')
        ->orderBy('order')
        ->get();
    return view('unipulse.page-sejarah', compact('menuItems'));
})->name('profil.sejarah');

Route::get('/profil/visi-misi', function() {
    $menuItems = \App\Models\Menu::where('is_active', true)
        ->whereNull('parent_id')
        ->with('children')
        ->orderBy('order')
        ->get();
    return view('unipulse.page-visi-misi', compact('menuItems'));
})->name('profil.visi-misi');

Route::get('/profil/sambutan-kepala-sekolah', function() {
    $menuItems = \App\Models\Menu::where('is_active', true)
        ->whereNull('parent_id')
        ->with('children')
        ->orderBy('order')
        ->get();
    return view('unipulse.page-sambutan', compact('menuItems'));
})->name('profil.sambutan');

Route::get('/{slug}', [FrontendController::class, 'page'])->name('page')->where('slug', '^[a-z0-9-]+$');

// Comment Routes
Route::post('/berita/{post}/komentar', [CommentController::class, 'store'])->name('comments.store')->middleware('throttle:10,1');

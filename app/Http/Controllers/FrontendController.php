<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Teacher;
use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Gallery;
use App\Models\Album;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function home()
    {
        // Get menu items from database
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        // Get latest posts for news section (5 posts: 1 featured + 4 cards)
        $latestPosts = \App\Models\Post::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('unipulse.home', compact('menuItems', 'latestPosts'));
    }
    
    public function posts(Request $request, $categorySlug = null)
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $query = Post::with(['category', 'user', 'tags'])
            ->where('status', 'published');
        
        // Filter by category slug if provided
        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }
        
        $posts = $query->orderBy('published_at', 'desc')
            ->paginate(24)
            ->withQueryString();
        
        $categories = Category::has('posts')->get();
        
        return view('unipulse.posts', compact('menuItems', 'posts', 'categories'));
    }
    
    public function postDetail($slug)
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $post = Post::with(['category', 'user', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Track view (prevent double count with session)
        if (!session()->has("post_{$post->id}_viewed")) {
            $post->incrementViews();
            session()->put("post_{$post->id}_viewed", true);
        }
        
        // Get latest posts for sidebar (exclude current post)
        $latestPosts = Post::with(['category', 'user'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();
        
        $categories = Category::has('posts')->get();
        
        return view('unipulse.post-detail', compact('menuItems', 'post', 'latestPosts', 'categories'));
    }
    
    public function teachers()
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $teachers = Teacher::orderBy('name')->get();

        return view('unipulse.teachers', compact('menuItems', 'teachers'));
    }
    
    public function achievements(Request $request)
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $query = Achievement::query();

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $achievements = $query->orderBy('year', 'desc')->get();

        return view('unipulse.achievements', compact('menuItems', 'achievements'));
    }
    
    public function extracurriculars()
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $extracurriculars = Extracurricular::orderBy('name')->get();

        return view('unipulse.extracurriculars', compact('menuItems', 'extracurriculars'));
    }
    
    public function gallery(Request $request)
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $albums = Album::withCount('galleries')
            ->has('galleries')
            ->orderBy('name')
            ->get();
        
        $query = Gallery::with('album');
        
        if ($request->filled('album')) {
            $query->where('album_id', $request->album);
        }
        
        $galleries = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();
        
        return view('unipulse.gallery', compact('menuItems', 'galleries', 'albums'));
    }
    
    public function page($slug)
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $page = \App\Models\Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('unipulse.page', compact('menuItems', 'page'));
    }
    
    public function guestbook()
    {
        // Get menu items for header
        $menuItems = \App\Models\Menu::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        
        $guestbooks = \App\Models\GuestBook::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('unipulse.guestbook', compact('menuItems', 'guestbooks'));
    }
    
    public function guestbookSubmit(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'purpose' => 'required|string',
        ]);
        
        // Create guestbook entry
        \App\Models\GuestBook::create([
            'day_date' => now(),
            'name' => $validated['name'],
            'position' => $validated['position'] ?? null,
            'address' => $validated['address'] ?? null,
            'purpose' => $validated['purpose'],
        ]);
        
        // Redirect back with success
        return redirect()->route('guestbook')->with('success', 'Terima kasih! Pesan Anda telah tercatat.');
    }
}

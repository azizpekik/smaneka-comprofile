<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post)
    {
        // Rate limiting: max 3 comments per IP per hour
        $key = 'comment:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors([
                    'comment' => 'Anda terlalu banyak mengirim komentar. Silakan coba lagi dalam ' . $seconds . ' detik.',
                ]);
        }

        RateLimiter::hit($key, 3600);

        // Validation
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'author_website' => 'nullable|url|max:255',
            'comment' => 'required|string|min:10|max:5000',
            'parent_id' => 'nullable|exists:comments,id',
        ], [
            'author_name.required' => 'Nama wajib diisi',
            'author_email.required' => 'Email wajib diisi',
            'author_email.email' => 'Format email tidak valid',
            'comment.required' => 'Komentar wajib diisi',
            'comment.min' => 'Komentar minimal 10 karakter',
            'comment.max' => 'Komentar maksimal 5000 karakter',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('comment_error', true);
        }

        // Honeypot check (spam prevention)
        if ($request->filled('website_url')) {
            // Bot filled the honeypot field
            return back()
                ->with('success', 'Terima kasih! Komentar Anda akan dimoderasi.');
        }

        // Create comment
        $comment = Comment::create([
            'post_id' => $post->id,
            'parent_id' => $request->parent_id,
            'author_name' => strip_tags($request->author_name),
            'author_email' => strip_tags($request->author_email),
            'author_website' => $request->filled('author_website') ? strip_tags($request->author_website) : null,
            'comment' => strip_tags($request->comment),
            'status' => Comment::STATUS_PENDING,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'cookies_consent' => $request->filled('save_commenter'),
        ]);

        // Save cookies if requested
        if ($request->filled('save_commenter')) {
            cookie()->queue('commenter_name', $request->author_name, 525600); // 1 year
            cookie()->queue('commenter_email', $request->author_email, 525600);
            cookie()->queue('commenter_website', $request->author_website, 525600);
        }

        // Send email notification to admin (optional, implement later)
        // Mail::to(admin_email)->send(new NewCommentNotification($comment));

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Terima kasih! Komentar Anda akan dimoderasi sebelum ditampilkan.');
    }
}

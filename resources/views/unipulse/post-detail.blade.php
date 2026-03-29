@extends('layouts.unipulse')

@section('title', $post->title . ' - SMANeka')
@section('description', Str::limit(strip_tags($post->content), 160))

@section('content')

<!-- News Details Section -->
<section id="news-details" class="news-details section">
  <div class="container">

    <!-- Article Header -->
    <div class="article-header" data-aos="fade-up">
      <div class="row g-4 align-items-center">
        <div class="col-lg-8">
          <div class="header-content">
            @if($post->category)
            <div class="topic-badges">
              <a href="#" class="badge-link">{{ $post->category->name }}</a>
            </div>
            @endif
            <h1 class="article-title">{{ $post->title }}</h1>
            <p class="article-subtitle">{{ Str::limit(strip_tags($post->content), 200) }}</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="author-card" data-aos="fade-left">
            @if($post->user)
            <div class="author-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
              {{ substr($post->user->name, 0, 1) }}
            </div>
            <div class="author-details">
              <h4>{{ $post->user->name }}</h4>
              <span class="author-role">Penulis</span>
            </div>
            @endif
            <div class="publish-details">
              <span><i class="bi bi-calendar3"></i> {{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
              <span><i class="bi bi-eye"></i> {{ $post->views_count ?? 0 }} Views</span>
            </div>
          </div>
        </div>
      </div><!-- End Article Header -->

      <!-- Featured Image -->
      <div class="featured-banner" data-aos="zoom-in" data-aos-delay="150">
        @if($post->thumbnail)
        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid">
        @else
        <img src="{{ asset('assets/img/blog/blog-hero-3.webp') }}" alt="{{ $post->title }}" class="img-fluid">
        @endif
        <div class="banner-caption">
          <i class="bi bi-camera"></i> {{ $post->title }}
        </div>
      </div><!-- End Featured Image -->

      <!-- Content Area -->
      <div class="row g-5">
        <!-- Main Content -->
        <div class="col-lg-8">
          <div class="main-content">

            <div class="text-block" id="content" data-aos="fade-up">
              <div class="article-body">
                {!! $post->content !!}
              </div>
            </div><!-- End Content Block -->

            <!-- Comments Section -->
            <div class="comments-section" data-aos="fade-up" data-aos-delay="200">
              <h3 class="comments-title">
                <i class="bi bi-chat-left-text"></i> 
                {{ $post->approvedComments()->count() }} Komentar
              </h3>

              <!-- Success Message -->
              @if(session('success'))
              <div class="alert alert-success" data-aos="fade-in">
                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                <div>
                  <strong>{{ session('success') }}</strong>
                </div>
              </div>
              @endif

              <!-- Error Messages -->
              @if($errors->any())
              <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i>
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <!-- Comments List -->
              <div class="comments-list">
                @forelse($post->approvedComments as $comment)
                <div class="comment-item">
                  <div class="comment-avatar">
                    @if($comment->author_email)
                    <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: bold;">
                      {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                    </div>
                    @endif
                  </div>
                  <div class="comment-body">
                    <div class="comment-header">
                      <h5 class="comment-author">{{ $comment->author_name }}</h5>
                      <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="comment-content">
                      <p>{{ $comment->comment }}</p>
                    </div>
                  </div>
                </div>
                @empty
                <div class="no-comments">
                  <i class="bi bi-chat-square"></i>
                  <p>Belum ada komentar. Jadilah yang pertama!</p>
                </div>
                @endforelse
              </div>

              <!-- Comment Form -->
              <div class="comment-form-wrapper" data-aos="fade-up">
                <h4>Tulis Komentar</h4>
                <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form">
                  @csrf
                  
                  <!-- Honeypot field (spam prevention) -->
                  <input type="text" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">
                  
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="author_name">Nama <span class="required">*</span></label>
                        <input 
                          type="text" 
                          id="author_name" 
                          name="author_name" 
                          value="{{ old('author_name', Cookie::get('commenter_name')) }}"
                          class="form-control"
                          placeholder="Nama Anda"
                          required
                        >
                        @error('author_name')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="author_email">Email <span class="required">*</span></label>
                        <input 
                          type="email" 
                          id="author_email" 
                          name="author_email" 
                          value="{{ old('author_email', Cookie::get('commenter_email')) }}"
                          class="form-control"
                          placeholder="email@example.com"
                          required
                        >
                        <span class="help-text">Email tidak akan dipublikasikan</span>
                        @error('author_email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-12">
                      <div class="form-group">
                        <label for="author_website">Website</label>
                        <input 
                          type="url" 
                          id="author_website" 
                          name="author_website" 
                          value="{{ old('author_website', Cookie::get('commenter_website')) }}"
                          class="form-control"
                          placeholder="https://website-anda.com"
                        >
                        <span class="help-text">Opsional</span>
                        @error('author_website')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-12">
                      <div class="form-group">
                        <label for="comment">Komentar <span class="required">*</span></label>
                        <textarea 
                          id="comment" 
                          name="comment" 
                          rows="6"
                          class="form-control"
                          placeholder="Tulis komentar Anda di sini..."
                          required
                        >{{ old('comment') }}</textarea>
                        <span class="help-text">Minimal 10 karakter, maksimal 5000 karakter</span>
                        @error('comment')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-12">
                      <div class="form-check">
                        <input 
                          type="checkbox" 
                          id="save_commenter" 
                          name="save_commenter"
                          {{ Cookie::has('commenter_name') ? 'checked' : '' }}
                          class="form-check-input"
                        >
                        <label for="save_commenter" class="form-check-label">
                          Save my name, email and website in this browser for the next time I comment.
                        </label>
                      </div>
                    </div>
                    
                    <div class="col-12">
                      <button type="submit" class="btn-submit-comment" id="submitCommentBtn">
                        <span class="btn-text">Kirim Komentar</span>
                        <span class="btn-loading" style="display: none;">
                          <span class="spinner-border spinner-border-sm me-2" role="hidden"></span>
                          Mengirim...
                        </span>
                        <i class="bi bi-send btn-icon"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div><!-- End Comment Form -->

            </div><!-- End Comments Section -->
            <div class="share-block" data-aos="fade-up" data-aos-delay="100">
              <h4>Bagikan Berita Ini:</h4>
              <div class="share-links">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}" target="_blank" class="share-link facebook">
                  <i class="bi bi-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-link twitter">
                  <i class="bi bi-twitter-x"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('posts.show', $post->slug)) }}" target="_blank" class="share-link whatsapp">
                  <i class="bi bi-whatsapp"></i>
                </a>
                <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(route('posts.show', $post->slug)) }}" class="share-link email">
                  <i class="bi bi-envelope"></i>
                </a>
              </div>
            </div><!-- End Share Block -->

          </div><!-- End Main Content -->
        </div><!-- End Main Content Column -->

        <!-- Sidebar -->
        <div class="col-lg-4">
          
          <!-- Latest News Sidebar -->
          <div class="sidebar-block" data-aos="fade-up">
            <h3 class="sidebar-title">Berita Terbaru</h3>
            
            <div class="sidebar-news-list">
              @foreach($latestPosts as $latestPost)
              @if($latestPost->id != $post->id)
              <article class="sidebar-article">
                <div class="sidebar-img">
                  @if($latestPost->thumbnail)
                  <img src="{{ asset('storage/' . $latestPost->thumbnail) }}" alt="{{ $latestPost->title }}" class="img-fluid" loading="lazy">
                  @else
                  <img src="{{ asset('assets/img/blog/blog-post-3.webp') }}" alt="{{ $latestPost->title }}" class="img-fluid" loading="lazy">
                  @endif
                </div>
                <div class="sidebar-body">
                  <h4><a href="{{ route('posts.show', $latestPost->slug) }}">{{ $latestPost->title }}</a></h4>
                  <div class="sidebar-meta">
                    <span><i class="bi bi-calendar3"></i> {{ $latestPost->published_at?->format('d M Y') }}</span>
                  </div>
                </div>
              </article>
              @endif
              @endforeach
            </div>

            <div class="text-center mt-4">
              <a href="{{ route('posts') }}" class="view-all-link">Lihat Semua Berita <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- End Latest News Sidebar -->

          <!-- Categories Sidebar -->
          @if($categories->count() > 0)
          <div class="sidebar-block" data-aos="fade-up" data-aos-delay="100">
            <h3 class="sidebar-title">Kategori</h3>
            <ul class="category-list">
              @foreach($categories as $category)
              <li>
                <a href="{{ route('posts.category', $category->slug) }}">
                  <span>{{ $category->name }}</span>
                  <span class="count">{{ $category->posts_count }}</span>
                </a>
              </li>
              @endforeach
            </ul>
          </div><!-- End Categories Sidebar -->
          @endif

        </div><!-- End Sidebar -->
      </div><!-- End Content Row -->

    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.querySelector('.comment-form');
    const submitBtn = document.getElementById('submitCommentBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    const btnIcon = submitBtn.querySelector('.btn-icon');

    if (commentForm) {
      commentForm.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-flex';
        btnIcon.style.display = 'none';

        // Form will submit normally, no need to prevent default
      });
    }
  });
</script>
@endpush

@push('styles')
<style>
  .news-details {
    padding: 80px 0;
  }

  .article-header {
    margin-bottom: 3rem;
  }

  .article-header .topic-badges {
    margin-bottom: 1rem;
  }

  .article-header .badge-link {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--accent-color);
    color: white;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .article-header .badge-link:hover {
    background: var(--accent-color-dark);
    transform: translateY(-2px);
  }

  .article-header .article-title {
    font-size: 2.5rem;
    line-height: 1.2;
    margin-bottom: 1rem;
    color: var(--heading-color);
  }

  .article-header .article-subtitle {
    font-size: 1.25rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
    line-height: 1.6;
  }

  .author-card {
    background: var(--surface-color);
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .author-card .author-avatar {
    margin: 0 auto 1rem;
  }

  .author-card .author-details h4 {
    font-size: 1.125rem;
    margin: 0;
    color: var(--heading-color);
  }

  .author-card .author-role {
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .author-card .publish-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
    font-size: 0.875rem;
  }

  .author-card .publish-details span {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
  }

  .featured-banner {
    position: relative;
    margin: 2rem 0;
    border-radius: 12px;
    overflow: hidden;
  }

  .featured-banner img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
  }

  .featured-banner .banner-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .article-body {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: color-mix(in srgb, var(--default-color), transparent 10%);
  }

  .article-body p {
    margin-bottom: 1.5rem;
  }

  .article-body h2,
  .article-body h3,
  .article-body h4 {
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
  }

  .article-body ul,
  .article-body ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
  }

  .article-body li {
    margin-bottom: 0.75rem;
  }

  .article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
  }

  .share-block {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid color-mix(in srgb, var(--accent-color), transparent 80%);
  }

  .share-block h4 {
    font-size: 1.125rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
  }

  .share-links {
    display: flex;
    gap: 0.75rem;
  }

  .share-link {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    transition: all 0.3s ease;
  }

  .share-link.facebook {
    background: #1877f2;
  }

  .share-link.twitter {
    background: #000;
  }

  .share-link.whatsapp {
    background: #25d366;
  }

  .share-link.email {
    background: #6c757d;
  }

  .share-link:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  }

  .sidebar-block {
    background: var(--surface-color);
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .sidebar-block .sidebar-title {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--heading-color);
    position: relative;
    padding-bottom: 0.75rem;
  }

  .sidebar-block .sidebar-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--accent-color);
  }

  .sidebar-news-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .sidebar-article {
    display: flex;
    gap: 1rem;
    transition: transform 0.3s ease;
  }

  .sidebar-article:hover {
    transform: translateX(8px);
  }

  .sidebar-article .sidebar-img {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
  }

  .sidebar-article .sidebar-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .sidebar-article .sidebar-body h4 {
    font-size: 1rem;
    margin: 0 0 0.5rem;
    line-height: 1.4;
  }

  .sidebar-article .sidebar-body h4 a {
    color: var(--heading-color);
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .sidebar-article .sidebar-body h4 a:hover {
    color: var(--accent-color);
  }

  .sidebar-article .sidebar-meta {
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .view-all-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--accent-color);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .view-all-link:hover {
    color: var(--accent-color-dark);
    transform: translateX(4px);
  }

  .category-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .category-list li {
    margin-bottom: 0.75rem;
  }

  .category-list li a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: color-mix(in srgb, var(--accent-color), transparent 95%);
    border-radius: 8px;
    color: var(--heading-color);
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .category-list li a:hover {
    background: color-mix(in srgb, var(--accent-color), transparent 90%);
    transform: translateX(4px);
  }

  .category-list li a .count {
    background: var(--accent-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  @media (max-width: 992px) {
    .article-header .article-title {
      font-size: 2rem;
    }

    .article-header .article-subtitle {
      font-size: 1.125rem;
    }
  }

  @media (max-width: 768px) {
    .article-header .article-title {
      font-size: 1.75rem;
    }

    .share-links {
      flex-wrap: wrap;
    }
  }

  /* Comments Section Styles */
  .comments-section {
    margin-top: 4rem;
    padding-top: 3rem;
    border-top: 2px solid color-mix(in srgb, var(--accent-color), transparent 85%);
  }

  .comments-title {
    font-size: 1.75rem;
    margin-bottom: 2rem;
    color: var(--heading-color);
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .comments-title i {
    color: var(--accent-color);
  }

  .alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 2px solid #10b981;
    padding: 1.25rem 1.5rem;
  }

  .alert-success i {
    color: #10b981;
  }

  .alert-success strong {
    font-size: 1.0625rem;
    font-weight: 600;
  }

  .alert-danger {
    background: color-mix(in srgb, #ef4444, transparent 90%);
    color: #dc2626;
    border: 1px solid #ef4444;
  }

  .alert ul {
    margin: 0;
    padding-left: 1.25rem;
  }

  .comments-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 3rem;
  }

  .comment-item {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--surface-color);
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .comment-item:hover {
    transform: translateX(4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .comment-avatar {
    flex-shrink: 0;
  }

  .comment-body {
    flex: 1;
  }

  .comment-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  .comment-author {
    font-size: 1.125rem;
    margin: 0;
    color: var(--heading-color);
    font-weight: 600;
  }

  .comment-date {
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .comment-content {
    color: color-mix(in srgb, var(--default-color), transparent 10%);
    line-height: 1.7;
  }

  .comment-content p {
    margin: 0;
  }

  .no-comments {
    text-align: center;
    padding: 3rem 1.5rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .no-comments i {
    font-size: 3rem;
    display: block;
    margin-bottom: 1rem;
    color: color-mix(in srgb, var(--default-color), transparent 50%);
  }

  .comment-form-wrapper {
    background: var(--surface-color);
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .comment-form-wrapper h4 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--heading-color);
  }

  .comment-form .form-group {
    margin-bottom: 1.5rem;
  }

  .comment-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--heading-color);
  }

  .comment-form .required {
    color: #ef4444;
  }

  .comment-form .form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--surface-color);
    color: var(--default-color);
  }

  .comment-form .form-control:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent-color), transparent 90%);
  }

  .comment-form .form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    margin-top: 0.125rem;
  }

  .comment-form .form-check-label {
    margin-left: 0.5rem;
    font-size: 0.9375rem;
    color: color-mix(in srgb, var(--default-color), transparent 10%);
    cursor: pointer;
  }

  .comment-form .help-text {
    display: block;
    font-size: 0.8125rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
    margin-top: 0.25rem;
  }

  .comment-form .error-message {
    display: block;
    font-size: 0.875rem;
    color: #ef4444;
    margin-top: 0.5rem;
  }

  .btn-submit-comment {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  .btn-submit-comment:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(49, 53, 117, 0.4);
    background: linear-gradient(135deg, #183152 0%, #313575 100%);
  }

  .btn-submit-comment:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
  }

  .btn-submit-comment .btn-icon {
    transition: transform 0.3s ease;
  }

  .btn-submit-comment:hover .btn-icon {
    transform: translateX(4px);
  }

  .btn-submit-comment .btn-loading {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  @media (max-width: 768px) {
    .comment-item {
      flex-direction: column;
      gap: 1rem;
    }

    .comment-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .comment-form-wrapper {
      padding: 1.5rem;
    }
  }
</style>
@endpush

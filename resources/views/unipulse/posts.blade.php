@extends('layouts.unipulse')

@section('title', 'Berita - SMANeka')
@section('description', 'Berita dan pengumuman terbaru dari SMANeka')

@section('content')

<!-- News Hero Section -->
<section id="news-hero" class="news-hero section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Berita Terbaru</h2>
    <p>Ikuti perkembangan dan kegiatan terbaru di SMANeka</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <!-- Category Filter -->
    @if($categories->count() > 0)
    <div class="category-filter mb-5" data-aos="fade-down">
      <div class="d-flex flex-wrap gap-2 justify-content-center">
        <a href="{{ route('posts') }}" class="category-pill {{ !request()->routeIs('posts.category') ? 'active' : '' }}">
          Semua Berita
        </a>
        @foreach($categories as $category)
        <a href="{{ route('posts.category', $category->slug) }}" class="category-pill {{ request()->routeIs('posts.category') && request()->route('category') == $category->slug ? 'active' : '' }}">
          {{ $category->name }}
        </a>
        @endforeach
      </div>
    </div>
    @endif

    @if($posts->count() > 0)
    
    <!-- Featured Article - Horizontal Layout -->
    <article class="highlight-article" data-aos="fade-up">
      <div class="row g-0 align-items-stretch">
        <div class="col-lg-7">
          <div class="highlight-img">
            @if($posts->first()->thumbnail)
            <img src="{{ asset('storage/' . $posts->first()->thumbnail) }}" alt="{{ $posts->first()->title }}" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/blog/blog-hero-3.webp') }}" alt="{{ $posts->first()->title }}" class="img-fluid">
            @endif
          </div>
        </div>
        <div class="col-lg-5">
          <div class="highlight-body">
            @if($posts->first()->category)
            <span class="topic-badge">{{ $posts->first()->category->name }}</span>
            @endif
            <h2 class="highlight-title">
              <a href="{{ route('posts.show', $posts->first()->slug) }}">{{ $posts->first()->title }}</a>
            </h2>
            <p class="highlight-summary">{{ Str::limit(strip_tags($posts->first()->content), 200) }}</p>
            <div class="highlight-footer">
              <div class="writer-info">
                @if($posts->first()->user)
                <div class="writer-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                  <span class="fs-4 fw-bold">{{ substr($posts->first()->user->name, 0, 1) }}</span>
                </div>
                @endif
                <div>
                  <a href="#" class="writer-name">{{ $posts->first()->user->name ?? 'Admin' }}</a>
                  <span class="publish-date">{{ $posts->first()->published_at?->format('d M Y') ?? $posts->first()->created_at->format('d M Y') }}</span>
                </div>
              </div>
              <a href="{{ route('posts.show', $posts->first()->slug) }}" class="read-link">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </article><!-- End Featured Article -->

    <!-- Secondary Articles Row -->
    <div class="row g-4 mt-2">
      @foreach($posts->skip(1)->take(3) as $post)
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 100 }}">
        <article class="article-card">
          <div class="card-img-wrapper">
            @if($post->thumbnail)
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
            @else
            <img src="{{ asset('assets/img/blog/blog-post-3.webp') }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
            @endif
            <span class="card-number">{{ $loop->iteration + 1 }}</span>
          </div>
          <div class="card-body-content">
            @if($post->category)
            <span class="topic-badge">{{ $post->category->name }}</span>
            @endif
            <h3 class="card-heading">
              <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
            </h3>
            <div class="writer-info compact">
              <span>by</span>
              <a href="#" class="writer-name">{{ $post->user->name ?? 'Admin' }}</a>
              <span class="sep">·</span>
              <span class="publish-date">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
            </div>
          </div>
        </article>
      </div><!-- End Article Card -->
      @endforeach
    </div><!-- End Secondary Articles Row -->

    <!-- All News List -->
    <div class="all-news-list mt-5" data-aos="fade-up" data-aos-delay="200">
      <div class="container section-title" data-aos="fade-up">
        <h3>Semua Berita</h3>
      </div>

      <div class="row g-4" id="newsList">
        @php
          $allNewsStart = 4; // Start from post #5
          $initialDisplay = 5; // Display 5 items initially
          $totalPosts = $posts->count();
          $hasMorePosts = $totalPosts > ($allNewsStart + $initialDisplay);
        @endphp

        @foreach($posts->skip($allNewsStart)->take($initialDisplay) as $post)
        <div class="col-12" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 50 }}">
          <article class="list-article">
            <span class="list-num">{{ $loop->iteration + $allNewsStart }}</span>
            <div class="list-img">
              @if($post->thumbnail)
              <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
              @else
              <img src="{{ asset('assets/img/blog/blog-post-square-2.webp') }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
              @endif
            </div>
            <div class="list-body">
              @if($post->category)
              <span class="topic-badge sm">{{ $post->category->name }}</span>
              @endif
              <h4 class="list-title">
                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
              </h4>
              <p class="list-excerpt">{{ Str::limit(strip_tags($post->content), 100) }}</p>
              <div class="writer-info compact">
                by <a href="#" class="writer-name">{{ $post->user->name ?? 'Admin' }}</a>
                <span class="sep">·</span>
                <span class="publish-date">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
              </div>
            </div>
          </article>
        </div>
        @endforeach
        
        <!-- Hidden News Items (for Load More) -->
        @foreach($posts->skip($allNewsStart + $initialDisplay) as $post)
        <div class="col-12 hidden-news" style="display: none;" data-aos="fade-up">
          <article class="list-article">
            <span class="list-num">{{ $loop->iteration + $allNewsStart + $initialDisplay }}</span>
            <div class="list-img">
              @if($post->thumbnail)
              <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
              @else
              <img src="{{ asset('assets/img/blog/blog-post-square-2.webp') }}" alt="{{ $post->title }}" class="img-fluid" loading="lazy">
              @endif
            </div>
            <div class="list-body">
              @if($post->category)
              <span class="topic-badge sm">{{ $post->category->name }}</span>
              @endif
              <h4 class="list-title">
                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
              </h4>
              <p class="list-excerpt">{{ Str::limit(strip_tags($post->content), 100) }}</p>
              <div class="writer-info compact">
                by <a href="#" class="writer-name">{{ $post->user->name ?? 'Admin' }}</a>
                <span class="sep">·</span>
                <span class="publish-date">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
              </div>
            </div>
          </article>
        </div>
        @endforeach
      </div>

      <!-- Load More Button -->
      @if($hasMorePosts)
      <div class="text-center mt-5" data-aos="fade-up">
        <button id="loadMoreBtn" class="btn-load-more">
          <span>Load More</span>
          <i class="bi bi-chevron-down"></i>
        </button>
      </div>
      @endif
    </div><!-- End All News List -->

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="text-center mt-5" data-aos="fade-up">
      {{ $posts->links() }}
    </div>
    @endif

    @else
    <div class="text-center py-5">
      <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
    </div>
    @endif

  </div>

</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const hiddenNews = document.querySelectorAll('.hidden-news');
    let currentIndex = 0;
    const itemsPerLoad = 10;

    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', function() {
        // Show next 10 items
        let count = 0;
        for (let i = currentIndex; i < hiddenNews.length && count < itemsPerLoad; i++) {
          const item = hiddenNews[i];
          item.style.display = 'block';
          // Trigger AOS refresh
          if (typeof AOS !== 'undefined') {
            AOS.refresh();
          }
          count++;
          currentIndex = i + 1;
        }

        // Hide button if no more items
        if (currentIndex >= hiddenNews.length) {
          loadMoreBtn.style.display = 'none';
        }
      });
    }
  });
</script>
@endpush

@push('styles')
<style>
  /* Category Filter Styles */
  .category-filter {
    padding: 1.5rem 0;
  }

  .category-pill {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: var(--surface-color);
    color: var(--heading-color);
    border-radius: 50px;
    font-size: 0.9375rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .category-pill:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .category-pill.active {
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border-color: #313575;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  @media (max-width: 768px) {
    .category-filter {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .category-filter .d-flex {
      flex-wrap: nowrap;
    }

    .category-pill {
      white-space: nowrap;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
    }
  }

  .btn-load-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2.5rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color-dark) 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .btn-load-more:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    background: linear-gradient(135deg, var(--primary-color-dark) 0%, var(--primary-color) 100%);
  }

  .btn-load-more i {
    transition: transform 0.3s ease;
  }

  .btn-load-more:hover i {
    transform: rotate(180deg);
  }

  .list-article {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
    padding: 1.5rem;
    background: var(--surface-color);
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .list-article:hover {
    transform: translateX(8px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .list-article .list-num {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent-color);
    min-width: 3rem;
    text-align: center;
  }

  .list-article .list-img {
    width: 120px;
    height: 120px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
  }

  .list-article .list-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .list-article:hover .list-img img {
    transform: scale(1.1);
  }

  .list-article .list-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .list-article .topic-badge.sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    align-self: flex-start;
  }

  .list-article .list-title {
    font-size: 1.125rem;
    margin: 0;
    line-height: 1.4;
  }

  .list-article .list-title a {
    color: var(--heading-color);
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .list-article .list-title a:hover {
    color: var(--accent-color);
  }

  .list-article .list-excerpt {
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
    line-height: 1.6;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .list-article .writer-info.compact {
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .list-article .writer-info .writer-name {
    color: var(--heading-color);
    font-weight: 600;
    text-decoration: none;
  }

  .list-article .writer-info .writer-name:hover {
    color: var(--accent-color);
  }

  @media (max-width: 768px) {
    .list-article {
      flex-direction: column;
      gap: 1rem;
    }

    .list-article .list-img {
      width: 100%;
      height: 200px;
    }

    .list-article .list-num {
      position: absolute;
      top: 1rem;
      left: 1rem;
      background: var(--accent-color);
      color: white;
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  }
</style>
@endpush

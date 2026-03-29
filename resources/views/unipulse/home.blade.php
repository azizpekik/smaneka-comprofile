@extends('layouts.unipulse')

@section('title', 'SMANeka - School Management System')
@section('description', 'Sistem Manajemen Sekolah SMANeka - Platform digital untuk mengelola informasi sekolah')

@section('content')

<!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="hero-block">
      <div class="row align-items-center g-4 g-xl-5">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
          <div class="hero-copy">
            <div class="top-badge"><i class="bi bi-mortarboard-fill"></i><span>{{ setting('hero_title', 'Sekolah Unggulan Berprestasi') }}</span></div>
            <h1>{{ setting('hero_subtitle', 'Mewujudkan Generasi Cerdas, Berkarakter, dan Berdaya Saing Global') }}</h1>
            <p>SMANeka berkomitmen mencetak lulusan yang tidak hanya unggul dalam akademik, tetapi juga memiliki karakter kuat dan siap menghadapi tantangan masa depan.</p>
            <div class="stats-strip">
              <div class="s-item"><strong>{{ setting('stat_1_value', '98%') }}</strong><span>{{ setting('stat_1_label', 'Kelulusan PTN') }}</span></div>
              <div class="s-divider"></div>
              <div class="s-item"><strong>{{ setting('stat_2_value', '50+') }}</strong><span>{{ setting('stat_2_label', 'Prestasi/Tahun') }}</span></div>
              <div class="s-divider"></div>
              <div class="s-item"><strong>{{ setting('stat_3_value', '100%') }}</strong><span>{{ setting('stat_3_label', 'Guru Bersertifikasi') }}</span></div>
            </div>
            <div class="hero-btns">
              <a href="{{ setting('hero_button_url', '/admin') }}" class="btn-apply">{{ setting('hero_button_text', 'Daftar Sekarang') }}</a>
              <a href="#" class="btn-tour" data-bs-toggle="modal" data-bs-target="#profileVideoModal"><i class="bi bi-play-circle-fill"></i> Profil Sekolah</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
          <div class="hero-visual">
            @if(setting('header_image'))
            <img src="{{ asset('storage/' . setting('header_image')) }}" alt="Kampus SMANeka" class="img-fluid campus-photo">
            @else
            <img src="{{ asset('assets/img/education/showcase-1.webp') }}" alt="Kampus SMANeka" class="img-fluid campus-photo">
            @endif
            <div class="accred-card">
              <i class="bi bi-patch-check-fill"></i>
              <div><strong>Terakreditasi A</strong><span>Unggul & Berkualitas</span></div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Hero Block -->

    <div class="features-block" data-aos="fade-up" data-aos-delay="150">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <article class="feat-card">
            <span class="feat-number">01</span>
            <div class="feat-icon"><i class="bi bi-book-fill"></i></div>
            <h3>{{ setting('feature_1_title', 'Kurikulum Inovatif') }}</h3>
            <p>{{ setting('feature_1_desc', 'Pembelajaran modern yang mengintegrasikan teknologi dan pendekatan student-centered untuk hasil optimal.') }}</p>
            <a href="{{ route('gallery') }}" class="feat-link">Explore Program <i class="bi bi-arrow-right"></i></a>
          </article>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <article class="feat-card featured">
            <span class="feat-number">02</span>
            <div class="feat-icon"><i class="bi bi-laptop-fill"></i></div>
            <h3>{{ setting('feature_2_title', 'Fasilitas Modern') }}</h3>
            <p>{{ setting('feature_2_desc', 'Laboratorium komputer, IPA, dan fasilitas pembelajaran lengkap dengan teknologi terkini.') }}</p>
            <a href="{{ route('gallery') }}" class="feat-link">Lihat Kampus <i class="bi bi-arrow-right"></i></a>
          </article>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <article class="feat-card">
            <span class="feat-number">03</span>
            <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
            <h3>{{ setting('feature_3_title', 'Guru Berkualitas') }}</h3>
            <p>{{ setting('feature_3_desc', 'Tenaga pendidik profesional dan berpengalaman yang siap membimbing setiap siswa meraih potensi terbaik.') }}</p>
            <a href="{{ route('gallery') }}" class="feat-link">Meet the Team <i class="bi bi-arrow-right"></i></a>
          </article>
        </div>
      </div>
    </div><!-- End Features Block -->

    <!-- Latest News Block -->
    @php $latestPost = $latestPosts->first(); @endphp
    @if($latestPost)
    <div class="event-block" data-aos="fade-up" data-aos-delay="200">
      <div class="row align-items-center gy-4">
        <div class="col-auto">
          <div class="event-cal">
            <span class="ec-month">{{ $latestPost->published_at?->format('M') ?? $latestPost->created_at->format('M') }}</span>
            <span class="ec-day">{{ $latestPost->published_at?->format('d') ?? $latestPost->created_at->format('d') }}</span>
          </div>
        </div>
        <div class="col">
          <div class="event-info">
            @if($latestPost->category)
            <span class="event-tag">{{ $latestPost->category->name }}</span>
            @endif
            <h3>{{ $latestPost->title }}</h3>
            <p>{{ Str::limit(strip_tags($latestPost->content), 200) }}</p>
          </div>
        </div>
        <div class="col-xl-auto col-12">
          <div class="event-actions">
            <a href="{{ route('posts.show', $latestPost->slug) }}" class="btn-rsvp">Baca Selengkapnya</a>
            <span class="event-timer"><i class="bi bi-clock-fill"></i> {{ $latestPost->published_at?->diffForHumans() ?? $latestPost->created_at->diffForHumans() }}</span>
          </div>
        </div>
      </div>
    </div>
    @endif<!-- End Latest News Block -->

  </div>
</section>


<!-- Who We Are Section (Visi Misi) -->
<section id="about" class="about section">
  <div class="container">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-5 align-items-stretch">
        <!-- Left - Image with Badge -->
        <div class="col-lg-5" data-aos="fade-right" data-aos-delay="150">
          <div class="campus-showcase">
            @if(setting('who_we_are_image'))
            <img src="{{ asset('storage/' . setting('who_we_are_image')) }}" alt="Kepala Sekolah SMANeka" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/education/kepala-sekolah.jpg') }}" alt="Kepala Sekolah SMANeka" class="img-fluid">
            @endif
            <div class="experience-badge">
              <span class="years">25+</span>
              <span class="label">Years of Excellence</span>
            </div>
          </div>
        </div>

        <!-- Right - Content -->
        <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
          <div class="story-content">
            <span class="subtitle">{{ setting('who_we_are_title', 'Who We Are') }}</span>
            <h2>{{ setting('who_we_are_desc', 'Membentuk Masa Depan Melalui Ilmu Pengetahuan & Penemuan') }}</h2>
            <p>{{ setting('who_we_are_paragraph', 'SMANeka berkomitmen untuk menciptakan lingkungan pembelajaran yang inspiratif dan inovatif, di mana setiap siswa dapat mengembangkan potensi akademik dan karakter mereka secara optimal.') }}</p>

            <div class="row g-4 mt-2">
              <div class="col-sm-6">
                <div class="purpose-block">
                  <i class="bi bi-bullseye"></i>
                  <h4>{{ setting('who_we_are_mission_title', 'Our Mission') }}</h4>
                  <p>{{ setting('who_we_are_mission', 'Menyelenggarakan pendidikan berkualitas dengan standar nasional dan internasional, mengembangkan potensi akademik dan non-akademik siswa secara optimal, serta menanamkan nilai-nilai karakter dan budi pekerti luhur.') }}</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="purpose-block">
                  <i class="bi bi-eye"></i>
                  <h4>{{ setting('who_we_are_vision_title', 'Our Vision') }}</h4>
                  <p>{{ setting('who_we_are_vision', 'Menjadi sekolah unggulan yang menghasilkan generasi cerdas, berkarakter, dan berdaya saing global berlandaskan iman dan taqwa.') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured News Section (Berita Unggulan) -->
<section id="featured-programs" class="featured-programs section light-background">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Berita Unggulan</h2>
    <p>Ikuti perkembangan dan kegiatan terbaru di SMANeka</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    @if($latestPosts->count() > 0)

    <!-- Featured News (Post Pertama) -->
    <div class="featured-program" data-aos="zoom-in" data-aos-delay="150">
      <div class="row g-0 align-items-stretch">
        <div class="col-lg-5">
          <div class="featured-img">
            @if($latestPosts->first()->thumbnail)
            <img src="{{ asset('storage/' . $latestPosts->first()->thumbnail) }}" alt="{{ $latestPosts->first()->title }}" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/education/campus-7.webp') }}" alt="{{ $latestPosts->first()->title }}" class="img-fluid">
            @endif
            <div class="featured-tag">
              <i class="bi bi-star-fill"></i> Featured
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="featured-content">
            @if($latestPosts->first()->category)
            <div class="category-label">{{ $latestPosts->first()->category->name }}</div>
            @endif
            <h3>{{ $latestPosts->first()->title }}</h3>
            <p>{{ Str::limit(strip_tags($latestPosts->first()->content), 200) }}</p>
            <div class="stats-row">
              <div class="stat-chip">
                <i class="bi bi-eye-fill"></i>
                <span>{{ $latestPosts->first()->views_count ?? 0 }} Views</span>
              </div>
              <div class="stat-chip">
                <i class="bi bi-calendar-fill"></i>
                <span>{{ $latestPosts->first()->published_at?->format('d M Y') }}</span>
              </div>
              <div class="stat-chip">
                <i class="bi bi-person-fill"></i>
                <span>{{ $latestPosts->first()->user->name ?? 'Admin' }}</span>
              </div>
            </div>
            <a href="{{ route('posts.show', $latestPosts->first()->slug) }}" class="explore-link">Baca Selengkapnya <i class="bi bi-arrow-right-circle-fill"></i></a>
          </div>
        </div>
      </div>
    </div><!-- End Featured News -->

    <!-- News Cards Grid (4 Posts Lainnya) -->
    <div class="row g-4 mt-2">

      @foreach($latestPosts->skip(1)->take(4) as $post)
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
        <div class="program-card">
          <div class="card-thumb">
            @if($post->thumbnail)
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/education/education-3.webp') }}" alt="{{ $post->title }}" class="img-fluid">
            @endif
            <div class="card-overlay">
              <span class="duration-badge">{{ $post->published_at?->diffForHumans() }}</span>
            </div>
          </div>
          <div class="card-body-content">
            @if($post->category)
            <span class="degree-type">{{ $post->category->name }}</span>
            @endif
            <h4>{{ $post->title }}</h4>
            <p>{{ Str::limit(strip_tags($post->content), 100) }}</p>
            <a href="{{ route('posts.show', $post->slug) }}" class="card-link">Baca Selengkapnya <i class="bi bi-chevron-right"></i></a>
          </div>
        </div>
      </div><!-- End News Card -->
      @endforeach

    </div>

    <div class="text-center mt-5" data-aos="zoom-in" data-aos-delay="600">
      <a href="{{ route('posts') }}" class="explore-link" style="font-size: 1.2rem;">
        Lihat Semua Berita <i class="bi bi-arrow-right-circle-fill"></i>
      </a>
    </div>

    @endif

  </div>

</section>

<!-- Profile Video Modal -->
<div class="modal fade" id="profileVideoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body p-0 position-relative">
        <!-- Close Button -->
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" 
                data-bs-dismiss="modal" aria-label="Close" onclick="stopVideo()" 
                style="z-index: 1000;"></button>
        
        <!-- Video Container -->
        <div class="ratio ratio-16x9">
          <iframe 
            id="youtubeVideo" 
            src="https://www.youtube.com/embed/0hX2hWnsZYI?enablejsapi=1&autoplay=0&rel=0&controls=1" 
            title="Profil Sekolah SMANeka" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
            frameborder="0">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  let player = null;
  let modalElement = null;

  // Load YouTube IFrame API
  function initYouTubePlayer() {
    if (typeof YT !== 'undefined' && YT.Player) {
      player = new YT.Player('youtubeVideo', {
        events: {
          'onReady': onPlayerReady
        }
      });
    }
  }

  function onPlayerReady(event) {
    // Player ready
  }

  // Stop YouTube video properly
  function stopVideo() {
    if (player && typeof player.pauseVideo === 'function') {
      player.pauseVideo();
      player.seekTo(0, true);
    } else {
      // Fallback: reload iframe
      const iframe = document.getElementById('youtubeVideo');
      if (iframe) {
        const currentSrc = iframe.src;
        iframe.src = currentSrc.split('?')[0] + '?enablejsapi=1&autoplay=0&rel=0&controls=1';
      }
    }
  }

  // Initialize when DOM is ready
  document.addEventListener('DOMContentLoaded', function() {
    modalElement = document.getElementById('profileVideoModal');
    
    // Load YouTube IFrame API
    if (typeof YT === 'undefined') {
      const tag = document.createElement('script');
      tag.src = 'https://www.youtube.com/iframe_api';
      const firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      
      // API will call onYouTubeIframeAPIReady when ready
      window.onYouTubeIframeAPIReady = initYouTubePlayer;
    } else {
      initYouTubePlayer();
    }

    // Auto-play video when modal opens
    modalElement?.addEventListener('shown.bs.modal', function () {
      if (player && typeof player.playVideo === 'function') {
        player.playVideo();
      } else {
        // Fallback: reload with autoplay
        const iframe = document.getElementById('youtubeVideo');
        if (iframe) {
          const currentSrc = iframe.src;
          iframe.src = currentSrc.split('?')[0] + '?enablejsapi=1&autoplay=1&rel=0&controls=1';
        }
      }
    });

    // Stop video when modal closes
    modalElement?.addEventListener('hidden.bs.modal', function () {
      stopVideo();
    });
  });
</script>
@endpush

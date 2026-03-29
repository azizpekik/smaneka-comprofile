@extends('layouts.unipulse')

@section('title', 'Prestasi - SMANeka')
@section('description', 'Daftar Prestasi Siswa-Siswi SMANeka')

@section('content')

<!-- Achievements Section -->
<section id="achievements" class="achievements section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Prestasi</h2>
      <p>Pencapaian membanggakan dari siswa-siswi SMANeka di berbagai kompetisi</p>
    </div><!-- End Section Title -->

    <!-- Year Filter -->
    @php
      $years = $achievements->pluck('year')->unique()->sort()->reverse()->values();
    @endphp
    
    @if($years->count() > 0)
    <div class="year-filter mb-5" data-aos="fade-down">
      <div class="d-flex flex-wrap gap-2 justify-content-center">
        <button class="year-pill active" onclick="filterAchievements('all')">
          Semua Tahun
        </button>
        @foreach($years as $year)
        <button class="year-pill" onclick="filterAchievements('{{ $year }}')">
          {{ $year }}
        </button>
        @endforeach
      </div>
    </div>
    @endif

    <div class="achievements-list" id="achievementsGrid" data-aos="fade-up" data-aos-delay="100">
      @php
        $initialDisplay = 5;
        $loadMoreStep = 3;
        $displayCount = $initialDisplay;
      @endphp
      
      @forelse($achievements->take($initialDisplay) as $achievement)
      <div class="achievement-row achievement-item" data-year="{{ $achievement->year }}" data-aos="fade-up">
        <div class="row align-items-center g-4">
          <div class="col-md-3 text-center">
            <div class="achievement-image-wrapper">
              @if($achievement->image)
              <img src="{{ asset('storage/' . $achievement->image) }}" alt="{{ $achievement->title }}" class="achievement-img img-fluid">
              @else
              <img src="{{ asset('assets/img/education/education-2.webp') }}" alt="{{ $achievement->title }}" class="achievement-img img-fluid">
              @endif
            </div>
          </div>
          <div class="col-md-9">
            <div class="achievement-info">
              <div class="achievement-year-badge">
                <i class="bi bi-calendar3"></i>
                <span>Tahun {{ $achievement->year }}</span>
              </div>
              <h3>{{ $achievement->title }}</h3>
              <p>{{ $achievement->description }}</p>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="no-achievements text-center py-5">
        <i class="bi bi-trophy" style="font-size: 4rem; color: #ccc;"></i>
        <p class="text-muted mt-3">Belum ada prestasi yang tercatat.</p>
      </div>
      @endforelse
      
      <!-- Hidden achievements for Load More -->
      @foreach($achievements->skip($initialDisplay) as $achievement)
      <div class="achievement-row achievement-item hidden-achievement" data-year="{{ $achievement->year }}" style="display: none;" data-aos="fade-up">
        <div class="row align-items-center g-4">
          <div class="col-md-3 text-center">
            <div class="achievement-image-wrapper">
              @if($achievement->image)
              <img src="{{ asset('storage/' . $achievement->image) }}" alt="{{ $achievement->title }}" class="achievement-img img-fluid">
              @else
              <img src="{{ asset('assets/img/education/education-2.webp') }}" alt="{{ $achievement->title }}" class="achievement-img img-fluid">
              @endif
            </div>
          </div>
          <div class="col-md-9">
            <div class="achievement-info">
              <div class="achievement-year-badge">
                <i class="bi bi-calendar3"></i>
                <span>Tahun {{ $achievement->year }}</span>
              </div>
              <h3>{{ $achievement->title }}</h3>
              <p>{{ $achievement->description }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Load More Button -->
    @if($achievements->count() > $initialDisplay)
    <div class="text-center mt-5" data-aos="fade-up">
      <button id="loadMoreBtn" class="btn-load-more">
        <span>Load More</span>
        <i class="bi bi-chevron-down"></i>
      </button>
    </div>
    @endif

  </div>
</section>

@endsection

@push('scripts')
<script>
  // Filter Achievements by Year
  function filterAchievements(year) {
    // Update active pill
    document.querySelectorAll('.year-pill').forEach(pill => {
      pill.classList.remove('active');
      if ((year === 'all' && pill.textContent.trim() === 'Semua Tahun') || 
          pill.textContent.trim() == year) {
        pill.classList.add('active');
      }
    });
    
    // Filter achievements (including hidden ones)
    const items = document.querySelectorAll('.achievement-item');
    items.forEach(item => {
      const itemYear = item.getAttribute('data-year');
      const isHidden = item.classList.contains('hidden-achievement');
      
      if (year === 'all' || itemYear == year) {
        if (isHidden) {
          item.style.display = 'none';
        } else {
          item.style.display = 'block';
          item.classList.remove('aos-animate');
          setTimeout(() => item.classList.add('aos-animate'), 50);
        }
      } else {
        item.style.display = 'none';
      }
    });
  }

  // Load More Functionality
  let loadMoreIndex = 0;
  const loadMoreStep = {{ $loadMoreStep }};
  const totalHidden = {{ $achievements->skip($initialDisplay)->count() }};

  document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', function() {
        const hiddenItems = document.querySelectorAll('.hidden-achievement');
        const itemsToShow = Array.from(hiddenItems).slice(loadMoreIndex, loadMoreIndex + loadMoreStep);
        
        itemsToShow.forEach((item, index) => {
          setTimeout(() => {
            item.style.display = 'block';
            item.classList.remove('aos-animate');
            setTimeout(() => item.classList.add('aos-animate'), 50);
          }, index * 100);
        });
        
        loadMoreIndex += loadMoreStep;
        
        // Hide button if no more items
        if (loadMoreIndex >= totalHidden) {
          loadMoreBtn.style.display = 'none';
        }
      });
    }
  });
</script>
@endpush

@push('styles')
<style>
  /* Year Filter Styles */
  .year-filter {
    padding: 1.5rem 0;
  }

  .year-pill {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: var(--surface-color);
    color: var(--heading-color);
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 50px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .year-pill:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .year-pill.active {
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border-color: #313575;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  @media (max-width: 768px) {
    .year-filter {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .year-filter .d-flex {
      flex-wrap: nowrap;
    }

    .year-pill {
      white-space: nowrap;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
    }
  }

  /* Load More Button */
  .btn-load-more {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
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

  .btn-load-more:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(49, 53, 117, 0.4);
  }

  .btn-load-more i {
    transition: transform 0.3s ease;
  }

  .btn-load-more:hover i {
    transform: rotate(180deg);
  }

  .achievements {
    padding: 80px 0;
    background: var(--surface-color);
  }

  .achievements-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .achievement-row {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
  }

  .achievement-row:hover {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    transform: translateY(-4px);
  }

  .achievement-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
  }

  .achievement-img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .achievement-row:hover .achievement-img {
    transform: scale(1.05);
  }

  .achievement-info {
    padding: 1rem;
  }

  .achievement-year-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
    color: var(--accent-color);
    font-weight: 600;
    margin-bottom: 1rem;
    background: color-mix(in srgb, var(--accent-color), transparent 92%);
    padding: 0.5rem 1rem;
    border-radius: 50px;
  }

  .achievement-info h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
    font-weight: 600;
    line-height: 1.3;
  }

  .achievement-info p {
    font-size: 1.0625rem;
    color: color-mix(in srgb, var(--default-color), transparent 15%);
    line-height: 1.8;
    margin: 0;
  }

  @media (max-width: 992px) {
    .achievement-row {
      padding: 1.5rem;
    }

    .achievement-img {
      height: 250px;
    }

    .achievement-info h3 {
      font-size: 1.25rem;
    }
  }

  @media (max-width: 768px) {
    .achievement-row {
      padding: 1.25rem;
    }

    .achievement-img {
      height: 200px;
    }

    .achievement-info h3 {
      font-size: 1.125rem;
    }

    .achievement-info p {
      font-size: 0.9375rem;
    }
  }
</style>
@endpush
